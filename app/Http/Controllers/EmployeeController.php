<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobTitles = JobTitle::all()->toArray();

        return view('employees.create',compact('jobTitles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'SSN' => ['required', 'string', 'max:255','unique:employees'],
            'phone' => ['required', 'string', 'max:10', 'unique:employees'],
            'dob' => ['required'],
            'doh' => ['required'],
            'salary' => ['required'],

        ]);
        $employee = Employee::create($request->all());

        $use_system = $employee->jobTitle->use_system;
        if($use_system==1){
            $password = 'aa'.substr($request['SSN'],0,8);
            $user = ['employee_id'=>$employee->id,'name'=>$request['name'],'phone'=>$request['phone'],'password'=>Hash::make($password)];
            $user = User::create($user);
        }


        return redirect()->back()->with('success','Success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $jobTitles = JobTitle::all()->toArray();

        return view('employees.edit',compact('employee','jobTitles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'SSN' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10'],
            'dob' => ['required','date'],
            'doh' => ['required','date'],
            'job_title' => ['required','numeric'],
            'salary' => ['required','numeric'],

        ]);

        $jobTitle = new JobTitle();

        $use_system = $jobTitle->find($request['job_title'])->use_system;

        if($use_system==1){
            $user = User::where('phone', '=', $employee['phone'])->first();
            if ($user === null) {
                $password = 'aa'.substr($request['SSN'],0,8);
                $user = ['name'=>$request['name'],'phone'=>$request['phone'],'password'=>Hash::make($password)];
                $user = User::create($user);
            }else{
                $user->update($request->all());
            }
        }else{
            $user = User::where('phone', '=', $employee['phone'])->first();
            if ($user !== null) {
                $user->delete();
            }
        }

        $employee->update($request->all());
        return redirect()->back()->with('success','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
