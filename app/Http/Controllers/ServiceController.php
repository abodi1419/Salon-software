<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;

class ServiceController extends Controller
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



        if(!Gate::allows('service',Auth::user())){

        }
        $services = Service::all();
        return view('services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('service_create',Auth::user())){
            abort(401);
        }
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::allows('service_create',Auth::user())){
            abort(401);
        }
        $request->validate([
            'name' => ['required','string','max:255'],
            'price' => ['required','numeric']
        ]);

        Service::create($request->all());
        return redirect()->back()->with('success','Success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        if(!Gate::allows('service_edit',Auth::user())){
            abort(401);
        }
        return view('services.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        if(!Gate::allows('service_edit',Auth::user())){
            abort(401);
        }
        $request->validate([
            'name' => ['required','string','max:255'],
            'price' => ['required','numeric']
        ]);
        $service->update($request->all());
        return redirect()->back()->with('success','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if(!Gate::allows('service_delete',Auth::user())){
            abort(401);
        }
        $service->delete();
        return redirect()->back();
    }
}
