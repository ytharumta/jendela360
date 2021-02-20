<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesMaster;
use App\Models\SalesDetail;
use App\Models\User;
use App\Models\StockPicking;
use DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = SalesMaster::count();
        $product = Product::all();
        return view('sales.index',[
            'total' => $total,
            'product' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pMaster = new SalesMaster;
        $pMaster->so_number = $request->so_number;
        $pMaster->buyer_name = $request->buyer_name;
        $pMaster->buyer_email = $request->buyer_email;
        $pMaster->buyer_telp = $request->buyer_telp;
        $pMaster->user_id = $request->session()->get('id');
        
        $total = 0;
        for($i=1; $i <= count($request->product_id); $i++){
            $total += $request->subtotal[$i];
        }
        $pMaster->total = $total;
        $pMaster->save();
        $pMasterId = $pMaster->id;

        for($i=1; $i <= count($request->product_id); $i++){
            $pDetail = new SalesDetail;
            $pDetail->sales_id = $pMasterId;
            $pDetail->product_id = $request->product_id[$i];
            $pDetail->product_price = $request->price[$i];
            $pDetail->qty = $request->qty[$i];
            $pDetail->save();

            for($j=0; $j < $request->qty[$i]; $j++){
                $picking = new StockPicking;
                $picking->product_id =  $request->product_id[$i];
                $picking->references = $request->so_number;
                $picking->picking_type = 'sales';
                $picking->save();
            }
        }
        return redirect()->route('sales.index')->with('status','SO has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $po = SalesMaster::findorFail($id);
        $podetail = SalesDetail::where('sales_id','=',$id)->delete();
        $picking = StockPicking::where('references','=',$po->so_number)->delete();
        $po->delete();
    }

    public function getSales()
    {
        $data = SalesMaster::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a style="margin-right:5px;" target="_blank" href="https://api.whatsapp.com/send?phone='.$row->buyer_telp.'&text=Invoice%20'.$row->so_number.'%3A%2C%20total%3A'.$row->total.'%20Terima%20kasih%20telah%20bertrantaksi" class="btn btn-link btn-sm">Whatsapp</a><a class="btn btn-link btn-sm" style="margin-right:5px;" href="/purchasing/edit/'.$row->id.'"><span class="icon ni ni-edit"></span></a>
                <a style="margin-right:5px;"  class="btn btn-link btn-sm" onclick="deleteProduct('.$row->id.')"><span class="icon ni ni-trash"></span></a>
                ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
