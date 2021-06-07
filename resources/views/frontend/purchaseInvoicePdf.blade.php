<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{__('Invoice number').' '. $purchaseInvoice['id']}}</title>

    <style>
        body {
            font-family:  sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 9px;
            line-height: 24px;
            font-family:  sans-serif;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: right;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td {
            text-align: left;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 30px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: 'XBRiyaz', sans-serif;
        }
        .rtl table {
            text-align: right;
        }
        .rtl table tr td {
            text-align: right;
        }
        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>
<div class="invoice-box {{ config('app.locale') == 'ar' ? 'rtl' : '' }}">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="65%" class="title">
                            <img src="{{ asset('storage/Narjis.jpeg') }}" style="width:100px; max-width:100px;">
                        </td>

                        <td width="35%">
                            {{ __('Invoice number') }}: {{ $purchaseInvoice['id'] }}<br>
                            {{ __('Invoice date') }}: {{ date_format($purchaseInvoice['created_at'],'d/m/Y') }}<br>
                            {{ __('Print date') }}: {{ Carbon\Carbon::now()->format('d/m/Y') }}<br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><h2>{{ __('Purchase invoice') }}</h2></td>
                    </tr>
                    <hr>

                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="50%">
                            <h2>{{ __('Vendor') }}</h2>
                            {{ $purchaseInvoice['vendor'] }}<br>
{{--                            <span dir="ltr">{{ __('Frontend/frontend.seller_phone') }}</span><br>--}}
{{--                            {{ __('Frontend/frontend.seller_vat') }}<br>--}}
{{--                            {{ __('Frontend/frontend.seller_address') }}--}}
                        </td>

                        <td width="50%">
                            <h2>{{ __('Customer') }}</h2>
                            صالون نرجس للتزيين النسائي<br>
                        </td>

                    </tr>
                    @if(strlen($purchaseInvoice['notes'])>0)
                    <tr class="information">
                        <td>{{ __('Notes').':'.$purchaseInvoice['notes'] }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>

        <table style="width: 100%">
            <tr class="heading">
                <td>#</td>
                <td>{{ __('Product name') }}</td>
                <td>{{ __('Price') }}</td>
                <td>{{ __('Quantity') }}</td>
                <td>{{ __('Sub total') }}</td>
            </tr>

            @foreach($purchaseInvoice->purchases as $num=>$purchase)
                <tr class="item">
                    <td>{{ $num+1 }}</td>
                    <td>{{ $purchase->product['name'] }}</td>
                    <td>{{$purchase['price'] }}</td>
                    <td>{{ $purchase['quantity'] }}</td>
                    <td>{{$purchase['price']*$purchase['quantity'] }}</td>
                </tr>
            @endforeach
        </table>



            <tr class="total">
                <td colspan="4"></td>
                <td>{{ __('Sub total') }}</td>
                <td>{{ $purchaseInvoice['sub_total']}}</td>
            </tr>

            <tr class="total">
                <td colspan="4"></td>
                <td>{{ __('Discount') }}</td>
                <td>{{  $purchaseInvoice['discount']}}</td>
            </tr>

            <tr class="total">
                <td colspan="4"></td>
                <td>{{ __('Total') }}</td>
                <td>{{$purchaseInvoice['total']}}</td>
            </tr>
    </table>

</div>
</body>
</html>
