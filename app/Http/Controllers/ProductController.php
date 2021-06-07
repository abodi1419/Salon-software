<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {



        if(Gate::allows('product',Auth::user())) {
            $products = Product::all();
            return view('products.index', compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('product_create',Auth::user())) {

            return view('products.create');
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
        if(Gate::allows('product_create',Auth::user())) {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric']
            ]);

            Product::create($request->all());
            return redirect()->back()->with('success', 'Success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(Gate::allows('product_edit',Auth::user())) {

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if(Gate::allows('product_edit',Auth::user())) {

            return view('products.edit',compact('product'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(Gate::allows('product_edit',Auth::user())) {
            $request->validate([
                'name' => ['required','string','max:255'],
                'price' => ['required','numeric']
            ]);

            $product->update($request->all());
            return redirect()->back()->with('success','Success');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(Gate::allows('product_delete',Auth::user())) {

        }

    }
}
