<?php
$delete=$jobTitle->delete_purchase_invoices;
$edit=$jobTitle->edit_purchase_invoices;
$view=$jobTitle->view_purchase_invoices;
?>
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
                    @if($edit||$delete)
                    <th scope="col">{{__('Actions')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse ($purchaseInvoices as $purchaseInvoice)
                <tr>

                    <th scope="row">{{$purchaseInvoice['id']}}</th>
                    <td>
                        @if($purchaseInvoice['state']==1)
                        <a href="{{route('purchase_invoices.show',$purchaseInvoice)}}" class="font-weight-bold p-2 text-success">{{__('Applied')}}</a>
                        @elseif($purchaseInvoice['state']==0)
                        <span class="font-weight-bold p-2 text-warning">{{__('Not applied')}}</span>
                        @else
                            <span class="font-weight-bold p-2 text-danger">{{__('Canceled')}}</span>
                        @endif
                    </td>
                    <td>{{$purchaseInvoice['total']}}</td>
                    <td>
                        {{date_format($purchaseInvoice['created_at'],'M d Y , H:i:s')}}
                    </td>
                    <td>{{$purchaseInvoice['vendor']}}</td>

                    <td>{{$purchaseInvoice->user['name']}}</td>
                    @if($edit||$delete)
                    <td>
                        <div class="row">
                            @if($edit)
                            <div class="col-3 m-0 p-1">

                                <form action="{{route('purchase_invoices.edit',$purchaseInvoice)}} " method="get">
                                    @csrf
                                    <button class="btn btn-white btn-circle btn-sm" type="submit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                            @if($delete)
                            <div class="col-3 m-0 p-1">
                                <form action="{{route('purchase_invoices.destroy',$purchaseInvoice)}} " method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-white btn-circle btn-sm text-danger" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
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
