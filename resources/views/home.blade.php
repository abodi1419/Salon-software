@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <tr>
                        <td class="font-weight-bold text-success">{{__('Today total sales').': '}}</td>
                        <td colspan="4">
                            <?php $total=0;?>
                            @foreach(\App\Models\SaleInvoice::query()->where('created_at','>',date('Y-m-d'))->where('state','=','1')->get() as $saleInvoice)
                                <?php $total+= $saleInvoice->total;?>
                            @endforeach
                            {{$total}}
                        </td>
                    </tr>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
