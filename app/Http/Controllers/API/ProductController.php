<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();
        if($product->count() > 0){
            return response()->json([
                'status'=>200,
                'product'=>$product
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Records Found!'
            ],404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'        =>'required|string',
            'price'       =>'required|numeric',
            'quantity'    =>'required|numeric',
            'category_id' =>'required',
            'brand_id'    =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $product = Product::create([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
                'description'=>$request->description,
                'price'=>$request->price,
                'quantity'=>$request->quantity,
                'thumbnail'=>$request->thumbnail,
                'category_id'=>$request->category_id,
                'brand_id'=>$request->brand_id,
            ]);
            if($product){
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Created Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something Went Wrong!'
                ],500);
            }
        }
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Product Found!'
            ],404);
        }
    }
    public function edit($id)
    {
        $product = Product::with('category')->find($id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Product Found!'
            ],404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'        =>'required|string',
            'price'       =>'required|numeric',
            'quantity'    =>'required|numeric',
            'category_id' =>'required',
            'brand_id'    =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $product = Product::find($id);
            $product->update([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
                'description'=>$request->description,
                'price'=>$request->price,
                'quantity'=>$request->quantity,
                'thumbnail'=>$request->thumbnail,
                'category_id'=>$request->category_id,
                'brand_id'=>$request->brand_id,
                'status'=>$request->status,
            ]);
            if($product){
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Updated Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something Went Wrong!'
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Product Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Product Found!'
            ],404);
        }
    }
}
