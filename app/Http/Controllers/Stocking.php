<?php

namespace App\Http\Controllers;

use App\Models\SaleService;
use Illuminate\Http\Request;
use PDF;
class Stocking extends Controller
{

    /**
     * Stocking constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $services=[];
        return view('stocking.index',compact('services'));
    }

    public function getStocking(Request $request){
        $fromDate = $request['from-date'];
        $toDate = $request['to-date'];
        $fromTime = $request['from-time'];
        $toTime = $request['to-time'];
        $start = $fromDate.' '.$fromTime;
        $end = $toDate.' '.$toTime;
        $services = SaleService::query()->where('state','=','1')
            ->where('created_at','>=',$start)
            ->where('created_at','<=',$end)
            ->get();
        $total=0;
        foreach ($services as $service){
            $total+=$service['after_discount'];
        }
        return view('stocking.index',compact('services','fromDate','fromTime','toDate','toTime','total'));
    }

    public function view($fromDate,$fromTime,$toDate,$toTime){
        $from = $fromDate.' '.$fromTime;
        $to = $toDate.' '.$toTime;
        $services = SaleService::query()->where('state','=','1')
            ->where('created_at','>=',$from)
            ->where('created_at','<=',$to)
            ->get();
        $total=0;
        foreach ($services as $service){
            $total+=$service['after_discount'];
        }
        $from = \DateTime::createFromFormat('Y-m-d H:i:s',$from);
        $to = \DateTime::createFromFormat('Y-m-d H:i:s',$to);
        $from = date_format($from,'H:i:s d/m/Y');
        $to = date_format($to,'H:i:s d/m/Y');
        $pdf = PDF::loadView('frontend.stockingPdf',compact('services','total','from','to'));
        $pdf->getMpdf()->charset_in='UTF-8';

        return $pdf->stream('sales.pdf');

    }


}
