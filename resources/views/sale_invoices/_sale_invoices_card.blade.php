<?php
    $delete=$jobTitle->delete_sale_invoices;
    $edit=$jobTitle->edit_sale_invoices;
    $view=$jobTitle->view_sale_invoices;
?>
    <div class="card p-3">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="bg-dark text-white">
                    <tr>

                        <th scope="col">{{__('Invoice number')}}</th>
                        <th scope="col">{{__('State')}}</th>
                        <th scope="col">{{__('Total')}}</th>
                        <th scope="col">{{__('Date')}}</th>
                        <th scope="col">{{__('Customer')}}</th>
                        <th scope="col">{{__('Made by')}}</th>
                        @if($delete||$edit)
                        <th scope="col">{{__('Actions')}}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($saleInvoices as $num=>$saleInvoice)
                        <tr>

                            <td>{{$saleInvoice['counter']}}</td>
                            <td>
                                @if($saleInvoice['state']==1)
                                    @if($view)
                                        <a href="{{route('sale_invoices.show',$saleInvoice)}}" class="font-weight-bold p-2 text-success">{{__('Applied')}}</a>
                                    @else
                                        <span class="font-weight-bold p-2 text-success">{{__('Applied')}}</span>
                                    @endif
                                @elseif($saleInvoice['state']==0)
                                    <span class="font-weight-bold p-2 text-warning">{{__('Saved')}}</span>
                                @else
                                    <span class="font-weight-bold p-2 text-danger">{{__('Canceled')}}</span>
                                @endif
                            </td>
                            <td>{{$saleInvoice['total']}}</td>
                            <td>
                                {{date_format($saleInvoice['created_at'],'M d Y , H:i:s')}}
                            </td>
                            <td>{{$saleInvoice['customer']}}</td>

                            <td>{{$saleInvoice->user['name']}}</td>
                            @if($edit||$delete)
                            <td>
                                <div class="row">
                                    <div class="col-3 m-0 p-1">
                                        @if($edit)
                                        <form action="{{route('sale_invoices.edit',$saleInvoice)}} " method="get">
                                            @csrf
                                            <button class="btn btn-white btn-circle btn-sm" type="submit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    <div class="col-3 m-0 p-1">
                                        @if($delete)
                                        <form action="{{route('sale_invoices.destroy',$saleInvoice)}} " method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-white btn-circle btn-sm text-danger" type="submit">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>


                            </td>
                            @endif
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
