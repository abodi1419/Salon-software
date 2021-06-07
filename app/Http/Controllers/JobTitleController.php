<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Gate;

class JobTitleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        if(Gate::allows('employee_create',Auth::user())) {

            return view('job_title.create');
        }else{
            abort(401);
        }
    }
    public function store(Request $request){
        if(Gate::allows('employee_create',Auth::user())) {
            Validator::make($request->toArray(), [
                'name' => ['required', 'string', 'max:255', 'unique:job_titles'],
            ])->validate();

            $isChecked = $request->has('use_system');

            if ($isChecked) {
                $request['use_system'] = 1;
                if ($request->has('create_sale_invoices')) {
                    $request['create_sale_invoices'] = 1;
                }
                if ($request->has('view_sale_invoices')) {
                    $request['view_sale_invoices'] = 1;
                }
                if ($request->has('edit_sale_invoices')) {
                    $request['edit_sale_invoices'] = 1;
                }
                if ($request->has('delete_sale_invoices')) {
                    $request['delete_sale_invoices'] = 1;
                }
                if ($request->has('create_purchase_invoices')) {
                    $request['create_purchase_invoices'] = 1;
                }
                if ($request->has('view_purchase_invoices')) {
                    $request['view_purchase_invoices'] = 1;
                }
                if ($request->has('edit_purchase_invoices')) {
                    $request['edit_purchase_invoices'] = 1;
                }
                if ($request->has('delete_purchase_invoices')) {
                    $request['delete_purchase_invoices'] = 1;
                }

                if ($request->has('create_product')) {
                    $request['create_product'] = 1;
                }
                if ($request->has('view_product')) {
                    $request['view_product'] = 1;
                }
                if ($request->has('edit_product')) {
                    $request['edit_product'] = 1;
                }
                if ($request->has('delete_product')) {
                    $request['delete_product'] = 1;
                }
                if ($request->has('create_service')) {
                    $request['create_service'] = 1;
                }
                if ($request->has('view_service')) {
                    $request['view_service'] = 1;
                }
                if ($request->has('edit_service')) {
                    $request['edit_service'] = 1;
                }
                if ($request->has('delete_service')) {
                    $request['delete_service'] = 1;
                }
                if ($request->has('create_employee')) {
                    $request['create_employee'] = 1;
                }
                if ($request->has('view_employee')) {
                    $request['view_employee'] = 1;
                }
                if ($request->has('edit_employee')) {
                    $request['edit_employee'] = 1;
                }
                if ($request->has('delete_employee')) {
                    $request['delete_employee'] = 1;
                }


                if ($request->has('show_reports')) {
                    $request['show_reports'] = 1;
                }
            } else {
                $request['use_system'] = 0;
            }

            JobTitle::create($request->all());
            return redirect()->back()->with('success', 'Success');
        }else{
            abort(401);
        }

    }
}
