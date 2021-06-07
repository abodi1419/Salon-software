<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        if(Employee::all()->first()!=null)
            $this->middleware('auth');
    }

    public function index()
    {



        if(Gate::allows('employee',Auth::user())) {
            $employees = Employee::all();

            return view('employees.index', compact('employees'));
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

        if(Gate::allows('employee_create',Auth::user())||Employee::all()->first()==null) {
            $jobTitles = JobTitle::all()->toArray();

            return view('employees.create',compact('jobTitles'));
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


        if(Gate::allows('employee_create',Auth::user())||Employee::all()->first()==null) {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'SSN' => ['required', 'string', 'max:255', 'unique:employees'],
                'phone' => ['required', 'string', 'max:10', 'unique:employees'],
                'dob' => ['required'],
                'doh' => ['required'],
                'salary' => ['required'],

            ]);



            $use_system = JobTitle::findOrFail($request['job_title'])->use_system;
            if ($use_system == 1) {

                $password = 'aa' . substr($request['SSN'], 0, 8);
                if($request->has('password')){
                    $request->validate([
                        'password' => ['required','string','min:8','confirmed']
                    ]);
                    $password=$request['password'];
                }
                $employee = Employee::create($request->all());
                $user = ['employee_id' => $employee->id, 'name' => $request['name'], 'phone' => $request['phone'], 'password' => Hash::make($password)];
                $user = User::create($user);
            }else{
                $employee = Employee::create($request->all());
            }


            return redirect()->back()->with('success', 'Success');
        }else{
            abort(401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if(Gate::allows('employee_edit',Auth::user())) {

        }else{
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        if(Gate::allows('employee_edit',Auth::user())) {
            $jobTitles = JobTitle::all()->toArray();
            return view('employees.edit',compact('employee','jobTitles'));
        }else{
            abort(401);
        }
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
        if(Gate::allows('employee_edit',Auth::user())) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'SSN' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:10'],
                'dob' => ['required','date'],
                'doh' => ['required','date'],
                'job_title' => ['required','numeric'],
                'salary' => ['required','numeric'],

            ]);

            $use_system = JobTitle::findOrFail($request['job_title'])->use_system;

            if($use_system==1){
                $user = User::where('phone', '=', $employee['phone'])->first();
                if ($user === null) {
                    $password = 'aa'.substr($request['SSN'],0,8);
                    if($request->has('password')){
                        $request->validate([
                            'password' => ['required','string','min:8','confirmed']
                        ]);
                        $password=$request['password'];
                    }
                    $user = ['name'=>$request['name'],'phone'=>$request['phone'],'password'=>Hash::make($password)];
                    $user = User::create($user);
                }else{
                    if($request->has('password')){
                        $request->validate([
                            'password' => ['required','string','min:8','confirmed']
                        ]);
                        $password=$request['password'];
                        $request['password']=Hash::make($password);
                    }
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
        }else{
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if(Gate::allows('employee_delete',Auth::user())) {

        }else{
            abort(401);
        }
    }
    public function calcCommissions(Request $request){
        $commissions =[];
        $start=$request['start'];
        $end=$request['end'];
        foreach (Employee::all() as $employee){
            if($employee->commission){
                array_push($commissions,$employee->saleServices()
                        ->where('state','=','1')
                        ->where('created_at','>',$start)
                        ->where('created_at','<',$end)
                        ->get()->toArray()+['employee_name'=>$employee->name,'commission'=>$employee['commission']]);
            }
        }
        $emps=[];
        foreach ($commissions as $commission){
            $total=0;
            for ($i=0;$i<count($commission)-2; $i++){
                $total+=$commission[$i]['after_discount'];
            }
            array_push($emps,['employee'=>$commission['employee_name'],'total'=>$total*($commission['commission']/100)]);
        }
        return view('employees.commissions',compact('emps','start','end'));
    }
}
