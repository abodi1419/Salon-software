<!DOCTYPE html>
<html lang="ar">
<!-- <html lang="ar"> for arabic only -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">--}}


    <title>فاتورة مبيعات</title>
    <style>
        .align-center{
            display: flex;
            display: -webkit-flex;
            justify-content: center;
            -webkit-justify-content: center;
            align-items: center;
            -webkit-align-items: center;
        }
        table, td, th {
            border: 1px solid black;
            padding-bottom: 5px;
            padding-top: 5px;
            padding-left: 5px;
            padding-right: 5px;

        }
        td {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;

        }
        @media print {
            @page {
                margin: 0 auto !important; /* imprtant to logo margin */
                sheet-size: 300px 250mm !important; /* imprtant to set paper size */
            }
            html {
                direction: rtl !important;
            }
            html,body{margin:0;padding:0}
            #printContainer {
                width: 250px !important;
                margin: auto !important ;
                /*padding: 10px;*/
                /*border: 2px dotted #000;*/
                text-align: justify !important;
            }


            .text-center{text-align: center !important;}
        }

    </style>
</head>
<body dir="rtl">
<h1 id="logo" class="text-center"><img src="{{asset('storage/Narjis.jpeg')}}" alt='Logo'></h1>

<div id='printContainer'>

    <table>
        <tr>
            <td>رقم الفاتورة: </td>
            <td><b>{{$counter}}</b></td>
        </tr>
        <tr>
            <td>تاريخ الانشاء: </td>
            <td><b>{{date_format($invoice['created_at'],'d/m/Y')}}<br></b></td>
        </tr>
        <tr>
            <td>وقت الانشاء: </td>
            <td><b>{{date_format($invoice['created_at'],'H:i:s')}}<br></b></td>
        </tr>

        <tr>
            <td>اسم العميل: </td>
            <td><b>{{$invoice['customer']}}</b></td>
        </tr>
    </table>
{{--    <p class="text-center"><img src="122>global/site/qr.png" alt="QR-code" class="left"/></p>--}}
    <br>
    <hr>
    @if(count($servicesInvoice))
    <table style="width: 100%;">
        <tr>
            <td>الخدمة</td>
            <td>الأخصائية</td>
            <td>الكمية</td>
            <td>السعر</td>
        </tr>
        @foreach($servicesInvoice as $serviceInvoice)
        <tr>
            <td ><b>{{$serviceInvoice['name']}}</b></td>
            <td ><b>{{$serviceInvoice['specialist']}}</b></td>
            <td><b>{{$serviceInvoice['quantity']}}</b></td>
            <td><b>{{$serviceInvoice['price']}}</b></td>
        </tr>
        @endforeach
    </table>
    @endif
    @if(count($productsInvoice))
        <br>
        <table style="width: 100%;">
            <tr>
                <td>المنتج</td>
                <td>الكمية</td>
                <td>السعر</td>
            </tr>
            @foreach($productsInvoice as $productInvoice)
                <tr>
                    <td ><b>{{$productInvoice['name']}}</b></td>
                    <td><b>{{$productInvoice['quantity']}}</b></td>
                    <td><b>{{$productInvoice['price']}}</b></td>
                </tr>
            @endforeach
        </table>
    @endif
    <hr>
    <br>
    <br>
    <table>
        <tr>
            <td>المجموع: </td>
            <td>{{$invoice['sub_total']}}</td>
        </tr>
        <tr>
            <td>الخصم: </td>
            <td>%{{$invoice['discount']}}</td>
        </tr>
        <tr>
            <td>الصافي: </td>
            <td><b>{{$invoice['total']}} ريال</b></td>
        </tr>
    </table>
    <hr>
    <br>
    <br>
    <br>


</div>
</body>
</html>
