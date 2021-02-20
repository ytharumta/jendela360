<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PurchasingMaster;
use App\Models\PurchasingDetail;
use App\Models\User;
use App\Models\StockPicking;
use DataTables;


class PurchasingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = PurchasingMaster::count();
        $product = Product::all();
        return view('purchasing.index',[
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
        $pMaster = new PurchasingMaster;
        $pMaster->po_number = $request->po_number;
        $pMaster->vendor_name = $request->vendor_name;
        $pMaster->user_id = $request->session()->get('id');
        
        $total = 0;
        for($i=1; $i <= count($request->product_id); $i++){
            $total += $request->subtotal[$i];
        }
        $pMaster->total = $total;
        $pMaster->save();
        $pMasterId = $pMaster->id;

        for($i=1; $i <= count($request->product_id); $i++){
            $pDetail = new PurchasingDetail;
            $pDetail->purhcasing_id = $pMasterId;
            $pDetail->product_id = $request->product_id[$i];
            $pDetail->product_price = $request->price[$i];
            $pDetail->qty = $request->qty[$i];
            $pDetail->save();

            for($j=0; $j < $request->qty[$i]; $j++){
                $picking = new StockPicking;
                $picking->product_id =  $request->product_id[$i];
                $picking->references = $request->po_number;
                $picking->picking_type = 'purchase';
                $picking->save();
            }
        }
        return redirect()->route('purchasing.index')->with('status','PO has been created');
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
        $po = PurchasingMaster::findorFail($id);
        $podetail = PurchasingDetail::where('purhcasing_id','=',$id)->delete();
        $picking = StockPicking::where('references','=',$po->po_number)->delete();
        $po->delete();
    }

    public function getPurchasing()
    {
        $data = PurchasingMaster::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a class="btn btn-link btn-sm" style="margin-right:5px;" href="/purchasing/edit/'.$row->id.'"><span class="icon ni ni-edit"></span></a>
                <a class="btn btn-link btn-sm" onclick="deleteProduct('.$row->id.')"><span class="icon ni ni-trash"></span></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
