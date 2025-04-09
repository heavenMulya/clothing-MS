<?php

namespace App\Http\Controllers\purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\sales;
use App\Models\Category;

class managesales extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       //
        //$fetch_Purchase=Purchase::all();
        $Purchase=sales::with('category')->get();
        $fetch_Purchase=$Purchase->map(function($Purchase){
            return [
             'id'=>$Purchase->id,
              'categoryName'=>$Purchase->category->categoryName,
              'sales_price'=>$Purchase->category->sales_price,
              'sales_quantity'=>$Purchase->sales_quantity,
              'total_price'=>$Purchase->sales_quantity*$Purchase->category->sales_price,
            ];

        });
        if(!$fetch_Purchase){
            return response()->json(
                ['message'=>'data is not Available',
                ],404);
        }
        return response()->json(
            ['message'=>'data is Available',
            'data'=>$fetch_Purchase,
            ],201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validate_data=$request->validate(
            [
            'category_id'=>'required|string|max:255',
            'sales_quantity'=>'required|int|max:255',
                   ]
            );
    
            $name_check=Category::where('id',$request->category_id)->first();
         if(!$name_check){
            return response()->json([
                'message'=>'Invalid Category Name',
            ],200);
         }
         $purchase_stock=Purchase::where('category_id',$request->category_id)->sum('purchase_quantity');
         $sales_stock=Sales::where('category_id',$request->category_id)->sum('sales_quantity');
         $remain_stock=$purchase_stock-$sales_stock;
         $sales_qty=$request->sales_quantity;
         if($sales_qty>$remain_stock){
            return response()->json([
                'message'=>'Sales Quntity of  Category '.$name_check['categoryName'].' Cant be Greated Than purchased Remaining is '.$remain_stock,
            ],401);
         }
                $add_data=sales::create($validate_data);
                if($add_data){
                    return response()->json([
                        'message'=>'Sales saved',
                    ],200);
                }
                return response()->json([
                    'message'=>'Sales Not Saved',
                ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $check=sales::where('id',$id)->first();
        if($check){
            return response()->json(
                [
    'message'=>'data is Available',
    'data'=>$check,
                ],200
                );
        }

        return response()->json(
            [
'message'=>'Wrong Sales Id'
            ],201
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validate_data=$request->validate(
            [
            'category_id'=>'required|string|max:255',
            'sales_quantity'=>'required|int|max:255',
                   ]
            );

        $check=sales::where('id',$id)->first();
        if($check){

            $update=$check->update([
                $check['category_id']=$request['category_id'],
                $check['sales_quantity']=$request['sales_quantity'],
              
            ]);
            if($update){
            return response()->json(
                [
    'message'=>'data is updated Successfully',
    'data'=>$check
                ],200
                );
        }
        return response()->json(
            [
'message'=>'data is not updated Successfully',
            ],404
            );
    
   
   
}
    return response()->json(
        [
'message'=>'Wrong Category Id',
        ],401
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $check=sales::where('id',$id)->first();
        if($check){
            $delete=$check->delete();
            if($delete){
            return response()->json(
                [
    'message'=>'data is deleted',
                ],200
                );
        }

        return response()->json(
            [
'message'=>'data is not deleted',
            ],404
            );
    }
}
}