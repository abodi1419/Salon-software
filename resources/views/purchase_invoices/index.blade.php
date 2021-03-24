@extends('layouts.app')

@section('content')
    <h4>{{__('Purchase invoices')}}</h4>

    <div class="card p-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>

                        <th scope="col">#</th>
                        <th scope="col">{{__('State')}}</th>
                        <th scope="col">{{__('Total')}}</th>
                        <th scope="col">{{__('Date')}}</th>
                        <th scope="col">{{__('Vendor')}}</th>

                        <th scope="col">{{__('Made by')}}</th>
                        <th scope="col">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($purchaseInvoices as $num=>$purchaseInvoice)
                        <tr>

                            <th scope="row">{{$num+1}}</th>
                            <td>
                                @if($purchaseInvoice['state']==1)
                                    <span class="font-weight-bold p-2 text-success">{{__('Applied')}}</span>
                                @else
                                    <span class="font-weight-bold p-2 text-warning">{{__('Not applied')}}</span>
                                @endif
                            </td>
                            <td>{{$purchaseInvoice['total']}}</td>
                            <td>
                                {{date_format($purchaseInvoice['created_at'],'M d Y , H:i:s')}}
                            </td>
                            <td>{{$purchaseInvoice['customer']}}</td>

                            <td>{{$purchaseInvoice->user['name']}}</td>

                            <td>
                                <div class="row">
                                    <div class="col-3 m-0 p-1">

                                        <form action="{{route('purchase_invoices.edit',$purchaseInvoice)}} " method="get">
                                            @csrf
                                            <button class="btn btn-white btn-circle btn-sm" type="submit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-3 m-0 p-1">
                                        <form action="{{route('purchase_invoices.destroy',$purchaseInvoice)}} " method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-white btn-circle btn-sm text-danger" type="submit">
                                                <i class="fas fa-trash-alt"></i>
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
