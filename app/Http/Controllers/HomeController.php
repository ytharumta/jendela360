<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesMaster;
use App\Models\SalesDetail;
use App\Models\User;
use App\Models\StockPicking;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request){

        
        if($request->session()->has('id')){
			// echo $request->session()->get('nama');
            $date = \Carbon\Carbon::today()->subDays(7);
            $salelastweek = SalesMaster::where('created_at','<=',$date)->sum('total');
            $salesweek = SalesMaster::whereBetween('created_at', [
                Carbon::parse('last monday')->startOfDay(),
                Carbon::parse('next friday')->endOfDay(),
            ])->sum('total');
            $percent = ($salesweek - $salelastweek) / $salesweek * 100;
            $sales = SalesMaster::sum('total');

            $countlastweek = SalesMaster::where('created_at','<=',$date)->count();
            $countweek = SalesMaster::whereBetween('created_at', [
                Carbon::parse('last monday')->startOfDay(),
                Carbon::parse('next friday')->endOfDay(),
            ])->count();
            $countpercent = ($countweek - $countlastweek) / $countweek * 100;
            $count = SalesMaster::count();
            
            
            $salestoday =  SalesMaster::whereDate('created_at',Carbon::today())->sum('total');
            $counttoday = SalesMaster::whereDate('created_at',Carbon::today())->count();

            $salesyesterday = SalesMaster::whereDate('created_at',Carbon::yesterday())->sum('total');
            $countyesterday = SalesMaster::whereDate('created_at',Carbon::yesterday())->count();

            $todaypercent = ($salestoday - $salesyesterday) / $salestoday * 100; 
            $ctodaypercent = ($counttoday - $countyesterday) / $counttoday * 100; 

            return view('home', [
                'saleslastweek' => $salelastweek,
                'salesweek' => $salesweek,
                'sales' => $sales,
                'percent' => $percent,
                'countlastweek' => $countlastweek,
                'countweek' => $countweek,
                'countpercent' => $countpercent,
                'count' => $count,
                'salestoday' => $salestoday,
                'counttoday' => $counttoday,
                'salesyesterday' => $salesyesterday,
                'countyesterday' => $countyesterday,
                'todaypercent' => $todaypercent,
                'ctodaypercent' => $ctodaypercent,
            ]);
		}else{
            return redirect()->route('login');
		}
    }
}
