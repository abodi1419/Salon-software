@extends('layouts.app')

@section('content')
    <?php
    $jobTitle = \Illuminate\Support\Facades\Auth::user()->employee->jobTitle;
    ?>
    <h3 class="text-center">{{__('Sale invoices')}}</h3>
    @if($jobTitle['view_sale_invoices']||$jobTitle['edit_sale_invoices'])
    <h4>{{__('Today invoices')}}</h4>
    <hr>
    <?php $saleInvoices = $todaySaleInvoices?>
    @include('sale_invoices._sale_invoices_card')
    <br>
    @endif
    @if($jobTitle['delete_sale_invoices'])
    <h4>{{__('Previous applied invoices')}}</h4>
    <hr>
    <?php $saleInvoices = $appliedSaleInvoices?>
    @include('sale_invoices._sale_invoices_card')
    <br>
    <h4>{{__('Saved invoices')}}</h4>
    <hr>
    <?php $saleInvoices = $savedSaleInvoices?>
    @include('sale_invoices._sale_invoices_card')
    <br>
    <h4>{{__('Canceled invoices')}}</h4>
    <hr>
    <?php $saleInvoices = $canceledSaleInvoices?>
    @include('sale_invoices._sale_invoices_card')
    @endif
@endsection
