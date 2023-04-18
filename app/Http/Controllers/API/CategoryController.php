<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();
        if($category->count() > 0){
            return response()->json([
                'status'=>200,
                'category'=>$category
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
            'name'=>'required|string|unique:categories|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $category = Category::create([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
            ]);
            if($category){
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Created Successfully'
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
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found!'
            ],404);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found!'
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
            $category = Category::find($id);
            $category->update([
                'name'=>$request->name,
                'slug'=>Str::of($request->name)->slug('_'),
                'status'=>$request->status,
            ]);
            if($category){
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Updated Successfully'
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
        $category = Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'status'=>202,
                'message'=>'Category Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found!'
            ],404);
        }
    }
}
