<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;

use PDF;

class SaleInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('sale_invoices',Auth::user())||Gate::allows('sale_invoices_edit',Auth::user())){
            $todaySaleInvoices = SaleInvoice::query()->where('created_at','>',date('Y-m-d'))->get();
            $appliedSaleInvoices = SaleInvoice::query()
                ->where('state','=','1')->get();
            $savedSaleInvoices = SaleInvoice::query()
                ->where('state','=','0')->get();
            $canceledSaleInvoices = SaleInvoice::query()
                ->where('state','=','2')->get();
            return view('sale_invoices.index',compact('todaySaleInvoices','appliedSaleInvoices','savedSaleInvoices','canceledSaleInvoices'));
        }else{
            abort(401);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        if(!Gate::allows('sale_invoices_create',Auth::user())){
            abort(401);
        }

        $latest = SaleInvoice::query()->where('state','=','1')->orderByDesc('id')->first();
        $counter = 1;
        if ($latest!=null){
            if(date_format($latest['created_at'],'Y-m-d')==date('Y-m-d')) {
                $counter =  $latest->counter+ 1;
            }
        }
        $invoicesCounter =$counter;
        $employees = Employee::query()->where('commission','>','0')->get();

        $products = Product::all();

        $services = Service::all();
        return view('sale_invoices.create',compact('products','services','invoicesCounter','employees'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::allows('sale_invoices_create',Auth::user())){
            abort(401);
        }

        $request->validate([
            'total'=>['numeric','min:1','required'],
            'customer' => ['max:255'],
        ]);
        $products=array();
        $services=array();
        $subTotal=0;
        foreach ($request->all() as $requestValue){
            if(substr( $requestValue, 0, 3 ) === 'p_-' ){
                $splited = explode('-',$requestValue);
                array_push($products, ['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
                $subTotal+=$splited['2']*$splited[3];
            }else if(substr( $requestValue, 0, 3 ) === 's_-' ){
                $splited = explode('-',$requestValue);
                $totalService = $splited[3]*$splited[4]-$splited[3]*$splited[4]*($request['discount']/100);
                array_push($services, ['employee_id'=>$splited[1],'service_id'=>$splited[2],'price'=>$splited[3],'quantity'=>$splited[4],'after_discount'=>$totalService,'state'=>$request['state']]);
                $subTotal+=$splited[3]*$splited[4];
            }
        }
        $total=$subTotal - $subTotal*($request['discount']/100);
        if($request['total']!=$total){
            return redirect()->back()->withErrors([__('Something went wrong!')]);
        }

        $invoice = Auth::user()->saleInvoices()->create($request->all()+['sub_total'=>$subTotal]);
        $productsInvoice=[];
        foreach ($products as $product) {
            $sale = $invoice->saleProducts()->create($product);
            if($invoice['state']==1) {
                $newQuantity = $sale->product['quantity'] - $sale['quantity'];
                if ($newQuantity < 0) {
                    $invoice->saleProducts()->delete();
                    $invoice->saleServices()->delete();
                    $invoice->delete();
                    return redirect()->back()->withErrors([__('Out of stock') . ' \'' . $sale->product['name'] . '\' ' .
                        __('Available quantity is') . ' ' . $sale->product['quantity']]);
                }
                $sale->product()->update(['quantity' => $newQuantity]);
            }
            array_push($productsInvoice,['name'=>$sale->product['name'],'price'=>$sale['price'],'quantity'=>$sale['quantity']]);

        }


        $servicesInvoice = [];
        foreach ($services as $service) {
            $sale = $invoice->saleServices()->create($service);
            array_push($servicesInvoice, ['name'=>$sale->service['name'],'price'=>$sale['price'],'quantity'=>$sale['quantity'],'specialist'=>$sale->employee['name']]);
        }
        if($request['state']==1) {
            $counter = $request['counter'];
            $this->print($counter, $servicesInvoice, $productsInvoice, $invoice);
        }
        return redirect()->back();
    }

    private function print($counter,$servicesInvoice,$productsInvoice,$invoice){

        $pdf = PDF::loadView('frontend.pdf',compact('servicesInvoice','productsInvoice','invoice','counter'));
        $pdf->getMpdf()->charset_in='UTF-8';

        $pdf->save('storage/saleInvoices/invoice'.$invoice['id'].'.pdf','F');
        exec('lp -o fit-to-page '.'storage/saleInvoices/invoice'.$invoice['id'].'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(SaleInvoice $saleInvoice)
    {

        if(!Gate::allows('sale_invoices',Auth::user()) || !Gate::allows('sale_invoices_edit',Auth::user())){
            abort(401);
        }

        $invoicePath = asset("storage/saleInvoices/invoice".$saleInvoice['id'].'.pdf');
        return view('sale_invoices.view',compact('invoicePath'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleInvoice $saleInvoice)
    {
        if(!Gate::allows('sale_invoices_edit',Auth::user())){
            abort(401);
        }
        $employees = Employee::query()->where('commission','>','0')->get();

        $products = Product::all();

        $services = Service::all();
        $soldServices=$saleInvoice->saleServices->toArray();
        $soldProducts=$saleInvoice->saleProducts->toArray();

        return view('sale_invoices.edit',compact('saleInvoice','employees','services','products','soldServices','soldProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleInvoice $saleInvoice)
    {
        if(!Gate::allows('sale_invoices_edit',Auth::user())){
            abort(401);
        }
        $request->validate([
            'total'=>['numeric','min:1','required'],
            'customer' => ['max:255'],
        ]);

        $products=array();
        $services=array();
        $subTotal=0;
        foreach ($request->all() as $requestValue){
            if(substr( $requestValue, 0, 3 ) === 'p_-' ){
                $splited = explode('-',$requestValue);
                array_push($products, ['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
                $subTotal+= $splited[2];
            }else if(substr( $requestValue, 0, 3 ) === 's_-' ){
                $splited = explode('-',$requestValue);
                $totalService = $splited[3]*$splited[4]-$splited[3]*$splited[4]*($request['discount']/100);
                array_push($services, ['employee_id'=>$splited[1],'service_id'=>$splited[2],'price'=>$splited[3],'quantity'=>$splited[4],'after_discount'=>$totalService,'state'=>$request['state']]);
                $subTotal+= $splited[3];
            }
        }
        $total=$subTotal - $subTotal*($request['discount']/100);
        if($request['total']!=$total){
            redirect()->back()->with('error',__('Something went wrong!'));
        }
        $productsInPurchases = $saleInvoice->saleProducts()->get();

        for ($i=0;$i<count($saleInvoice->saleProducts);$i++){
            $product = $productsInPurchases[$i]->product;
            $product->quantity+=$productsInPurchases[$i]->quantity;
            $product->save();
        }
        $saleInvoice->saleProducts()->delete();
        $saleInvoice->saleServices()->delete();

        $productsInvoice=[];
        foreach ($products as $product) {
            $sale = $saleInvoice->saleProducts()->create($product);
            if($saleInvoice['state']==1) {
                $newQuantity = $sale->product['quantity'] - $sale['quantity'];
                if ($newQuantity < 0) {
                    $saleInvoice->saleProducts()->delete();
                    $saleInvoice->saleServices()->delete();
                    $saleInvoice->delete();
                    return redirect()->back()->withErrors([__('Out of stock') . ' \'' . $sale->product['name'] . '\' ' .
                        __('Available quantity is') . ' ' . $sale->product['quantity']]);
                }
                $sale->product()->update(['quantity' => $newQuantity]);
            }
            array_push($productsInvoice,['name'=>$sale->product['name'],'price'=>$sale['price'],'quantity'=>$sale['quantity']]);
        }

        $servicesInvoice=[];
        foreach ($services as $service) {
            $sale = $saleInvoice->saleServices()->create($service);
            array_push($servicesInvoice, ['name'=>$sale->service['name'],'price'=>$sale['price'],'quantity'=>$sale['quantity'],'specialist'=>$sale->employee['name']]);
        }
        if($saleInvoice['counter']==0){
            $latest = SaleInvoice::query()->where('state','=','1')->orderByDesc('id')->first();
            $counter = 1;
            if ($latest!=null){
                if(date_format($latest['created_at'],'Y-m-d')==date('Y-m-d')) {
                    $counter =  $latest->counter+ 1;
                    $saleInvoice->update($request->all()+['sub_total'=>$subTotal,'counter'=>$counter]);
                }
            }
        }else{
            $saleInvoice->update($request->all()+['sub_total'=>$subTotal]);

        }
        if($request['state']==1){
            $this->print($saleInvoice->counter,$servicesInvoice,$productsInvoice,$saleInvoice);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleInvoice $saleInvoice)
    {
        if(!Gate::allows('sale_invoices_delete',Auth::user())){
            abort(401);
        }
        $productsInPurchases = $saleInvoice->saleProducts()->get();
        $servicesInPurchases = $saleInvoice->saleServices()->get();
        foreach ($servicesInPurchases as $service){
            $service->state = 2;
            $service->save();
        }
        for ($i=0;$i<count($saleInvoice->saleProducts);$i++){
            $product = $productsInPurchases[$i]->product;
            $product->quantity+=$productsInPurchases[$i]->quantity;
            $product->save();
        }
        if($saleInvoice->state==0){
            $saleInvoice->saleServices()->delete();
            $saleInvoice->saleProducts()->delete();
            $saleInvoice->delete();
        }else {
            $saleInvoice->state = 2;
            $saleInvoice->save();
        }
        return redirect()->to("sale_invoices");
    }
}
