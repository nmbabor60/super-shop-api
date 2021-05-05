<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        /*{
        'purchase_date':'2021-04-12',
        'challan_no':'1231', 'supplier_id', 'note',
        'total_amount' , 'created_by',

        'items':[
            {purchase_id, product_id, big_unit_price, small_unit_price, big_unit_qty, small_unit_qty, big_unit_sales_price,small_unit_sales_price},

            {purchase_id, product_id, big_unit_price, small_unit_price, big_unit_qty, small_unit_qty, big_unit_sales_price,small_unit_sales_price},
        ]

        }*/

        DB::beginTransaction();
    try{
        $input = $request->all();
        $validator = \Validator::make($input,[
            'total_amount'=>'required',
            'supplier_id'=>'required',
            'challan_no'=>'required',
            'items.product_id'=>'required',
            'items.big_unit_qty'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],403);
        }
        $input['created_by'] = \Auth::user()->id;
        $purchaseInput = [
            'purchase_date'=>date('Y-m-d',strtotime($request->purchase_date)),
            'challan_no'=>$request->challan_no,
            'supplier_id'=>$request->supplier_id,
            'note'=>$request->note ?? '',
             'total_amount'=>$request->total_amount ,
            'created_by'=>\Auth::user()->id
        ];
        $purchase = Purchase::create($purchaseInput);
        foreach ($request->items as $item){
            $purchaseItemInput = [
                'purchase_id'=>$purchase->id,
                'product_id'=>$item->product_id,
                'big_unit_price'=>$item->big_unit_price,
                'small_unit_price'=>$item->small_unit_price,
                'big_unit_qty'=>$item->big_unit_qty,
                'small_unit_qty'=>$item->big_unit_qty
            ];
            $purchaseItem = PurchaseItem::create($purchaseItemInput);
        }

        DB::commit();
            return response()->json("Successfully Inserted",201);

        }catch(\Exception $e){
        DB::rollback();
            return response()->json(['error'=>$e->errorInfo[2]],500);
        }

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
        //
    }
}
