<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobTitleController extends Controller
{

    public function create(){
        return view('job_title.create');
    }
    public function store(Request $request){
        Validator::make($request->toArray(), [
            'name' => ['required', 'string', 'max:255','unique:job_titles'],
        ])->validate();

        $isChecked = $request->has('use_system');

        if($isChecked){
            $request['use_system']=1;
            if($request->has('create_sale_invoices')){
                $request['create_sale_invoices']=1;
            }if($request->has('view_sale_invoices')){
                $request['view_sale_invoices']=1;
            }if($request->has('edit_sale_invoices')){
                $request['edit_sale_invoices']=1;
            }if($request->has('delete_sale_invoices')){
                $request['delete_sale_invoices']=1;
            }if($request->has('create_purchase_invoices')){
                $request['create_purchase_invoices']=1;
            }if($request->has('view_purchase_invoices')){
                $request['view_purchase_invoices']=1;
            }if($request->has('edit_purchase_invoices')){
                $request['edit_purchase_invoices']=1;
            }if($request->has('delete_purchase_invoices')){
                $request['delete_purchase_invoices']=1;
            }if($request->has('show_reports')){
                $request['show_reports']=1;
            }
        }else{
            $request['use_system']=0;
        }

        JobTitle::create($request->all());
        return redirect()->back()->with('success','Success');

    }
}
