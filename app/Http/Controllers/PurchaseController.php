<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryChallan;
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

        /*
        {
            "purchase_date":"2021-05-26",
            "challan_no":"r2424",
            "supplier_id":2,
            "note":"First Purchase",
            "total_amount":106000,
            "created_by":1,
            "items":[
                {
                    "product_id":1,
                    "small_unit_price":21000,
                    "small_unit_qty":4,
                    "small_unit_sales_price":22000,

                    "big_unit_price":21000 (nullable),
                    "big_unit_qty":4  (nullable),
                    "big_unit_sales_price":22000  (nullable)
                },
                {
                    "product_id":2,
                    "small_unit_price":11000,
                    "small_unit_qty":2,
                    "small_unit_sales_price":12000
                }
            ]
        }

         */

        DB::beginTransaction();
    try{
        $input = $request->all();
        //return response()->json($input,201);
        $validator = \Validator::make($input,[
            'total_amount'=>'required',
            'supplier_id'=>'required',
            'challan_no'=>'required',
            'items.*.product_id'=>'required',
            'items.*.small_unit_qty'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],403);
        }
        $input['created_by'] = \Auth::user()->id;
        /* Start Purchase  */
        $purchaseInput = [
            'purchase_date'=>date('Y-m-d',strtotime($request->purchase_date)),
            'challan_no'=>$request->challan_no,
            'supplier_id'=>$request->supplier_id,
            'note'=>$request->note ?? '',
             'total_amount'=>$request->total_amount ,
            'created_by'=>\Auth::user()->id
        ];
        $purchase = Purchase::create($purchaseInput);
        // End Purchase Table Work

        // Start single product purchase
        foreach ($request->items as $singleItem){
            $item = (object) $singleItem;
            $purchaseItemInput = [
                'purchase_id'=>$purchase->id,
                'product_id'=>$item->product_id,
                'big_unit_price'=>$item->big_unit_price??null,
                'small_unit_price'=>$item->small_unit_price,
                'big_unit_qty'=>$item->big_unit_qty??null,
                'small_unit_qty'=>$item->small_unit_qty
            ];
            $purchaseItem = PurchaseItem::create($purchaseItemInput);
            // Start Inventory/Stock
            $existProduct = Inventory::where('product_id',$item->product_id)->first();
            $available_big_unit_qty = $item->big_unit_qty ?? 0;
            $available_small_unit_qty = $item->small_unit_qty;
            if($existProduct!=''){
                $available_big_unit_qty += $existProduct->available_big_unit_qty;
                //$available_big_unit_qty = $available_big_unit_qty + $existProduct->available_big_unit_qty;
                $available_small_unit_qty += $existProduct->available_small_unit_qty;
            }


            $inventoryInput = [
                'product_id'=>$item->product_id,
                'available_big_unit_qty'=>$available_big_unit_qty,
                'available_small_unit_qty'=>$available_small_unit_qty,
                'big_unit_sales_price'=>$item->big_unit_sales_price?? null,
                'small_unit_sales_price'=>$item->small_unit_sales_price,
            ];
            if($existProduct!=''){
               $existProduct->update($inventoryInput);
                $inventory = $existProduct;
            }else{
                $inventory = Inventory::create($inventoryInput);
            }
            $inventoryChallan = [
                'inventory_id'=>$inventory->id,
                'product_id'=>$item->product_id,
                'big_unit_sales_price'=>$item->big_unit_sales_price?? null,
                'small_unit_sales_price'=>$item->small_unit_sales_price,
                'big_unit_cost_price'=>$item->big_unit_price?? null,
                'small_unit_cost_price'=>$item->small_unit_price,
                'big_unit_qty'=>$item->big_unit_qty?? null,
                'small_unit_qty'=>$item->small_unit_qty,
            ];
            $inventoryChallan = InventoryChallan::create($inventoryChallan);
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
