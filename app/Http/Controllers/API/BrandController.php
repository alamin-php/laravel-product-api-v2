<?php

namespace App\Http\Controllers\API;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::latest()->get();
        if($brand->count() > 0){
            return response()->json([
                'status'=>200,
                'brand'=>$brand
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
            'name'=>'required|string|unique:brands|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $brand = Brand::create([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
            ]);
            if($brand){
                return response()->json([
                    'status'=>200,
                    'message'=>'Brand Created Successfully'
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
        $brand = Brand::find($id);
        if($brand){
            return response()->json([
                'status'=>200,
                'brand'=>$brand
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Brand Found!'
            ],404);
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if($brand){
            return response()->json([
                'status'=>200,
                'brand'=>$brand
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Brand Found!'
            ],404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $brand = Brand::find($id);
            $brand->update([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
                'status'=>$request->status,
            ]);
            if($brand){
                return response()->json([
                    'status'=>200,
                    'message'=>'Brand Updated Successfully'
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
        $brand = Brand::find($id);
        if($brand){
            $brand->delete();
            return response()->json([
                'status'=>202,
                'message'=>'Brand Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Brand Found!'
            ],404);
        }
    }
}
