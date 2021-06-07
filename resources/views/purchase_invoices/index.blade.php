@extends('layouts.app')

@section('content')
    <?php
        $jobTitle = \Illuminate\Support\Facades\Auth::user()->employee->jobTitle;
    ?>
    <h3 class="text-center">{{__('Purchase invoices')}}</h3>

    <h4>{{__('Applied invoices')}}</h4>
    <hr>
    <?php $purchaseInvoices = $appliedPurchaseInvoices?>
    @include('purchase_invoices._purchase_invoices_card')
    <br>
    <h4>{{__('Saved invoices')}}</h4>
    <hr>
    <?php $purchaseInvoices = $savedPurchaseInvoices?>
    @include('purchase_invoices._purchase_invoices_card')
    <br>
    <h4>{{__('Canceled invoices')}}</h4>
    <hr>
    <?php $purchaseInvoices = $canceledPurchaseInvoices?>
    @include('purchase_invoices._purchase_invoices_card')

@endsection
