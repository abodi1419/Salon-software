<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseInvoiceController extends Controller
{
    /**
     * PurchaseInvoiceController constructor.
     */
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

        if(Gate::allows('purchase_invoices',Auth::user())){
            $purchaseInvoices = PurchaseInvoice::all();
            return view('purchase_invoices.index', compact('purchaseInvoices'));
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
        if(Gate::allows('purchase_invoices_create',Auth::user())){
            $products = Product::all();
            return view('purchase_invoices.create',compact('products'));
        }else{
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::allows('purchase_invoices_create',Auth::user())){
            $request->validate([
                'total'=>['numeric','required'],
                'vendor' => ['max:255'],
            ]);
            $products=array();
            foreach ($request->all() as $requestValue){
                if(substr( $requestValue, 0, 3 ) === 'p_-' ){
                    $splited = explode('-',$requestValue);
                    array_push($products, ['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
                    //array_push($products,['product_id'=>$splited[1],'price'=>$splited[2],'quantity'=>$splited[3]]);
                }
            }
            $invoice = Auth::user()->purchaseInvoices()->create($request->all());
            foreach ($products as $product){
                $purchase = $invoice->purchases()->create($product);
                $newQuantity = $purchase->product['quantity']+$purchase['quantity'];
                $purchase->product()->update(['quantity'=>$newQuantity]);
            }
            return redirect()->back();
        }else{
            abort(401);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        if(Gate::allows('purchase_invoices_edit',Auth::user())){
            $products = Product::all();
            $purchasedProducts = $purchaseInvoice->purchases->toArray();
        return view('purchase_invoices.edit',compact('purchaseInvoice','products','purchasedProducts'));
        }else{
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        if(Gate::allows('purchase_invoices_edit',Auth::user())){
            $request->validate([
                'total'=>['numeric','min:1','required'],
                'vendor' => ['max:255'],
            ]);
            $products=array();
            foreach ($request->all() as $requestValue){
                if(substr( $requestValue, 0, 3 ) === 'p_-' ) {
                    $splited = explode('-', $requestValue);
                    array_push($products, ['product_id' => $splited[1], 'price' => $splited[2], 'quantity' => $splited[3]]);
                }
            }
            $productsInPurchases = $purchaseInvoice->purchases()->get();

            for ($i=0;$i<count($purchaseInvoice->purchases);$i++){
                $product = $productsInPurchases[$i]->product;
                $product->quantity-=$productsInPurchases[$i]->quantity;
                $product->save();
            }
            $purchaseInvoice->purchases()->delete();


            foreach ($products as $product) {
                $purchase = $purchaseInvoice->purchases()->create($product);
                $newQuantity = $purchase->product['quantity'] + $purchase['quantity'];
                if ($newQuantity < 0) {
                    $purchase->delete();
                    redirect()->back()->with('error', 'Out of stock' . $purchase->product['name']);
                }
                $purchase->product()->update(['quantity' => $newQuantity]);
            }


            $purchaseInvoice->update($request->all());
            return redirect()->back();
        }else{
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        if(Gate::allows('purchase_invoices_delete',Auth::user())){
            $productsInPurchases = $purchaseInvoice->purchases()->get();
            for ($i=0;$i<count($purchaseInvoice->purchases);$i++){
                $product = $productsInPurchases[$i]->product;
                $product->quantity-=$productsInPurchases[$i]->quantity;
                $product->save();
            }
            $purchaseInvoice->delete();
            return redirect('purchase_invoices');
        }else{
            abort(401);
        }

    }
}
