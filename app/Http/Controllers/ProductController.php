<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Product;
use App\Models\StockPicking;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total = Product::count();

        return view('product.index',[
            'total' => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->vehicle_name = $request->product_name;
        $product->price = $request->price;
        $product->user_id = $request->session()->get('id');
        $product->save();
        return redirect()->route('product.index')->with('status','Product has been created');
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
        $product = Product::findorFail($id);
        return view('product.edit',[
            'product' => $product
        ]);
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
        $product = Product::findorFail($id);
        if($request->product_name){
            $product->vehicle_name = $request->product_name;
        }
        if($request->price){
            $product->price = $request->price;
        }
        $product->update();
        return redirect()->route('product.index')->with('status','Product has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);
        $product->delete();
    }

    public function getProduct()
    {
        $data = Product::all();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a class="btn btn-link btn-sm" style="margin-right:5px;" href="/product/edit/'.$row->id.'"><span class="icon ni ni-edit"></span></a>
            <a class="btn btn-link btn-sm" onclick="deleteProduct('.$row->id.')"><span class="icon ni ni-trash"></span></a>';
            return $actionBtn;
        })
        ->addColumn('stock',function($row){
            $purchase = StockPicking::where('product_id','=',$row->id)->where('picking_type','=','purchase')->get()->count();
            $sales = StockPicking::where('product_id','=',$row->id)->where('picking_type','=','sales')->get()->count();
            $stock = $purchase - $sales; 
            return $stock;
            })
            ->rawColumns(['action','stock'])
            ->make(true);
    }

    public function price(Request  $request){
        $product = Product::findorFail($request->id);
        return $product;
    }
}
