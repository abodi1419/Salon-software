<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;

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
        if(Gate::allows('sale_invoices',Auth::user())){
            $saleInvoices = SaleInvoice::all();
            return view('sale_invoices.index',compact('saleInvoices'));
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
        if(!session()->exists('counter')){
            session()->put('counter',1);
        }
        $invoicesCounter = session()->get('counter');
        $latest = SaleInvoice::latest()->first();
        if ($latest!=null){
            if(date_format($latest['created_at'],'Y-m-d')!=date('Y-m-d')){
                session()->put('counter',1);
            }
        }
        $jobTitles = JobTitle::query()->where("use_system",'=','0')->get();
        $employees=[];
        foreach ($jobTitles as $jobTitle) {
            array_push($employees,$jobTitle->employees);
        }

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
        //
        

        session()->put('counter',session()->get('counter')+1);

        $request->validate([
            'total'=>['numeric','min:1','required'],
            'customer' => ['max:255'],
        ]);
        $products=array();
        $services=array();
        foreach ($request->all() as $requestValue){
            if(substr( $requestValue, 0, 3 ) === 'p_-' ){
                $splited = explode('-',$requestValue);
                array_push($products, ['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
            }else if(substr( $requestValue, 0, 3 ) === 's_-' ){
                $splited = explode('-',$requestValue);
                array_push($services, ['employee_id'=>$splited[1],'service_id'=>$splited[2],'price'=>$splited[3],'quantity'=>$splited[4]]);
            }
        }
        $invoice = Auth::user()->saleInvoices()->create($request->all());

        foreach ($products as $product) {
            $sale = $invoice->saleProducts()->create($product);
            $newQuantity = $sale->product['quantity'] - $sale['quantity'];
            if ($newQuantity < 0) {
                $invoice->delete();
                redirect()->back()->with('error', 'Out of stock' . $sale->product['name']);
            }
            $sale->product()->update(['quantity' => $newQuantity]);
        }


        foreach ($services as $service) {
            $sale = $invoice->saleServices()->create($service);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(SaleInvoice $saleInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleInvoice $saleInvoice)
    {
        $jobTitles = JobTitle::query()->where("use_system",'=','0')->get();
        $employees=[];
        foreach ($jobTitles as $jobTitle) {
            array_push($employees,$jobTitle->employees);
        }

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

        $request->validate([
            'total'=>['numeric','min:1','required'],
            'customer' => ['max:255'],
        ]);

        $products=array();
        $services=array();
        foreach ($request->all() as $requestValue){
            if(substr( $requestValue, 0, 3 ) === 'p_-' ){
                $splited = explode('-',$requestValue);
                array_push($products, ['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
            }else if(substr( $requestValue, 0, 3 ) === 's_-' ){
                $splited = explode('-',$requestValue);
                array_push($services, ['employee_id'=>$splited[1],'service_id'=>$splited[2],'price'=>$splited[3],'quantity'=>$splited[4]]);
            }
        }
        $productsInPurchases = $saleInvoice->saleProducts()->get();

        for ($i=0;$i<count($saleInvoice->saleProducts);$i++){
            $product = $productsInPurchases[$i]->product;
            $product->quantity+=$productsInPurchases[$i]->quantity;
            $product->save();
        }
        $saleInvoice->saleProducts()->delete();
        $saleInvoice->saleServices()->delete();


        foreach ($products as $product) {
            $sale = $saleInvoice->saleProducts()->create($product);
            $newQuantity = $sale->product['quantity'] - $sale['quantity'];
            if ($newQuantity < 0) {
                $sale->delete();
                redirect()->back()->with('error', 'Out of stock' . $sale->product['name']);
            }
            $sale->product()->update(['quantity' => $newQuantity]);
        }


        foreach ($services as $service) {
            $sale = $saleInvoice->saleServices()->create($service);
        }
        $saleInvoice->update($request->all());
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
        $productsInPurchases = $saleInvoice->saleProducts()->get();

        for ($i=0;$i<count($saleInvoice->saleProducts);$i++){
            $product = $productsInPurchases[$i]->product;
            $product->quantity+=$productsInPurchases[$i]->quantity;
            $product->save();
        }
        $saleInvoice->saleProducts()->delete();
        $saleInvoice->saleServices()->delete();
        $saleInvoice->delete();
        return redirect()->to("sale_invoices");
    }
}
