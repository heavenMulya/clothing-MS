<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class ManageCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fetch_category=Category::all();
        if(!$fetch_category){
            return response()->json(
                ['message'=>'data is not Available',
                ],200);
        }
        return response()->json(
            ['message'=>'data is Available',
            'data'=>$fetch_category,
            ],201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validate_data=$request->validate(
        [
        'categoryName'=>'required|string|max:255',
        'purchase_price'=>'required|int',
        'sales_price'=>'required|int',
               ]
        );

        $name_check=Category::where('categoryName',$request->categoryName)->first();
        if ($name_check){
            return response()->json([
                'message'=>'Category Name Already Taken',
            ],401);
        }
            $add_data=Category::create($validate_data);
            if($add_data){
                return response()->json([
                    'message'=>'Category Name Created',
                ],200);
            }
            return response()->json([
                'message'=>'Category Name not Created',
            ],201);
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $check=Category::where('id',$id)->first();
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
'message'=>'Wrong Category Id'
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
            'purchase_price'=>'required|int',
            'sales_price'=>'required|int',
                   ]
            );

        $check=Category::where('id',$id)->first();
        if($check){
            $update=$check->update([
                $check['purchase_price']=$request['purchase_price'],
                $check['sales_price']=$request['sales_price'],
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
        $check=Category::where('id',$id)->first();
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
    
    return response()->json(
        [
'message'=>'Wrong Category Id',
        ],404
        );
    }

}
