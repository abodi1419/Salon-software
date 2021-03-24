@extends('layouts.app')

@section('content')
    <h4>{{__('Employees')}}</h4>

    <div class="card p-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('SSN')}}</th>
                        <th scope="col">{{__('Phone')}}</th>
                        <th scope="col">{{__('Job title')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($employees as $num=>$employee)
                        <tr>
                            <th scope="row">{{$num+1}}</th>
                            <td><a href="{{route('employees.show',$employee)}} ">{{$employee['name']}}</a></td>
                            <td>{{$employee['SSN']}}</td>
                            <td>{{$employee['phone']}}</td>
                            <td>{{$employee->jobTitle['name']}}</td>
                            <td>
                                <div class="row">
                                    <div class="col-3 m-0 p-1">

                                        <form action="{{route('employees.edit',$employee)}} " method="get">
                                            @csrf
                                            <button class="btn btn-white btn-circle btn-sm" type="submit">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-3 m-0 p-1">
                                        <form action="{{route('employees.destroy',$employee)}} " method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-white btn-circle btn-sm text-danger" type="submit">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>


                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
