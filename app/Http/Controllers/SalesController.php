<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

class SalesController extends Controller
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
            "client_id",total_amount,payable_amount,paid_amount,prev_amount,discount,note,
            "items":[
                    {
                        product_id, big_unit_qty, small_unit_qty,  big_unit_sales_price, small_unit_sales_price
                    },
                    {
                        product_id, big_unit_qty, small_unit_qty,  big_unit_sales_price, small_unit_sales_price
                    }
                ]
        }

         */
        DB::beginTransaction();
        try {

            // Invoice No Generate
            $totalSales = ProductSales::count()+1;
            $serialNo =  sprintf("%04d", $totalSales);
            $invoiceNo = 'SI-'.$serialNo;

            $salesInput = [
                'client_id'=>$request->client_id??null,
                'invoice_no'=>$invoiceNo,
                'sales_date'=>date('Y-m-d'),
                'total_amount'=>$request->total_amount,
                'payable_amount'=>$request->payable_amount,
                'paid_amount'=>$request->paid_amount,
                'prev_amount'=>$request->prev_amount,
                'discount'=>$request->discount,
                'note'=>$request->note,
                'created_by'=>\Auth::user()->id,
            ];
            $sales = ProductSales::create($salesInput);

            foreach ($request->items as $singleItem) {
                $item = (object)$singleItem;


            }



            DB::commit();
            return response()->json("Successfully Submitted", 201);

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
