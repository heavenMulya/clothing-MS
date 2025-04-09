<?php

namespace App\Http\Controllers\purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Category;

class managePurchase extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$fetch_Purchase=Purchase::all();
        $Purchase=Purchase::with('category')->get();
        $fetch_Purchase=$Purchase->map(function($Purchase){
            return [
             'id'=>$Purchase->id,
              'categoryName'=>$Purchase->category->categoryName,
              'purchase_price'=>$Purchase->category->purchase_price,
              'purchase_quantity'=>$Purchase->purchase_quantity,
              'total_price'=>$Purchase->purchase_quantity*$Purchase->category->purchase_price,
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
            'purchase_quantity'=>'required|int|max:255',
                   ]
            );
    
            $name_check=Category::where('id',$request->category_id)->first();
         if(!$name_check){
            return response()->json([
                'message'=>'Invalid Category Name',
            ],200);
         }
         
                $add_data=Purchase::create($validate_data);
                if($add_data){
                    return response()->json([
                        'message'=>'Purchase saved',
                    ],200);
                }
                return response()->json([
                    'message'=>'Purchase Not Saved',
                ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        //$check=Purchase::where('id',$id)->first();
        $Purchase=Purchase::where('id',$id)->with('category')->get();
        $check=$Purchase->map(function($Purchase){
            return  [
             'id'=>$Purchase->id,
             'category_id'=>$Purchase->category_id,
              'categoryName'=>$Purchase->category->categoryName,
              'purchase_quantity'=>$Purchase->purchase_quantity,
            ];
        });
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
'message'=>'Wrong Purchase Id'
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
            'purchase_quantity'=>'required|int|max:255',
                   ]
            );

        $check=Purchase::where('id',$id)->first();
        if($check){

            $update=$check->update([
                $check['category_id']=$request['category_id'],
                $check['purchase_quantity']=$request['purchase_quantity'],
              
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
        $check=Purchase::where('id',$id)->first();
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