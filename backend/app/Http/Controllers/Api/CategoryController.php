<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all()->where('isDelete', false);
        if (count($categories) > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $categories
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No categories found'
            ], 404);
        }
    }

    public function show(Request $request)
    {
        $category = Category::find($request->id)->where('isDelete', false);
        if ($category != "") {
            return response()->json([
                'status' => 'success',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), ([
            'name' => 'required|unique:categories|max:100',
            'description' => 'max:100',
        ]));
        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validate->messages()
            ], 400);
        } else {
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->isDelete = false;
            $category->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully'
        ], 201);
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->id)->where('isDelete', false);
        if ($category) {
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->isDelete = true;
            $category->deleted_at = now()->toDate();
            $category->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        }
    }
}
