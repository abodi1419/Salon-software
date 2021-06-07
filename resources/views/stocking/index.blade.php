@extends('layouts.app')

@section('content')
    <h4>{{__('Sales')}}</h4>
    <div class="card p-3">
        <form  method="post" action="{{asset('stocking/get_stocking')}}">
            @csrf

            <div class="form-group row text-center">
                <div class="col-md-6">
                    <label for="from-date">{{__('From date')}}</label>
                    <input type="date" value="<?php if(!isset($fromDate)) echo date('Y-m-d'); else echo $fromDate;?>" class="form-control" name="from-date" id="from-date">
                </div>
                <div class="col-md-6">
                    <label for="to-date">{{__('To date')}}</label>
                    <input type="date" value="<?php if(!isset($toDate)) echo date('Y-m-d'); else echo $toDate;?>" class="form-control" name="to-date" id="to-date">
                </div>

            </div>
            <div class="form-group row text-center">
                <div class="col-md-6">
                    <label for="from-time">{{__('Time')}}</label>
                    <input type="time" value="<?php if(!isset($fromTime)) echo '08:00:00'; else echo $fromTime;?>" class="form-control" name="from-time" id="from-time">
                </div>
                <div class="col-md-6">
                    <label for="to-time">{{__('Time')}}</label>
                    <input type="time" value="<?php if(!isset($toTime)) echo date('H:i:s'); else echo $toTime;?>" class="form-control" name="to-time" id="to-time">
                </div>

            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">{{__('Show')}}</button>
            </div>
        </form>
    </div>
    <div class="card p-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('Service/Product')}}</th>
                        <th scope="col">{{__('Specialist')}}</th>
                        <th scope="col">{{__('Price')}}</th>
                        <th scope="col">{{__('Discount')}}</th>
                        <th scope="col">{{__('Total')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($services as $num=>$service)
                        <tr>
                            <th scope="row">{{$num+1}}</th>
                            <td>{{$service->service['name']}}</td>
                            <td>{{$service->employee['name']}}</td>
                            <td>{{$service['price']}}</td>
                            <td>{{($service['price']-$service['after_discount'])/$service['price']*100}}%</td>
                            <td>{{$service['after_discount']}}</td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            @if(isset($total))
                <div class="text-center">
                    <label>{{__('Total').': '}} <span class="font-weight-bold text-success">{{$total.' '.__('SAR')}}</span></label>
                </div>
                <div>

                    <a href="{{asset("stocking/view/$fromDate/$fromTime/$toDate/$toTime")}}" class="btn btn-primary">{{__('Print')}}</a>
                </div>
            @endif
        </div>
    </div>
@endsection
