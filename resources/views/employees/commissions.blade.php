@extends('layouts.app')

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h4>
            {{__('Commissions from').' '.date_format(date_create($start),'d/m/Y').' '.__('To').' '.date_format(date_create($end),'d/m/Y')}}
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>{{__('Employee')}}</th>
                        <th>{{__('Commission in range')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($emps as $emp)
                        <tr>
                            <td>{{$emp['employee']}}</td>
                            <td class="font-weight-bold">{{$emp['total']}} ريال</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
