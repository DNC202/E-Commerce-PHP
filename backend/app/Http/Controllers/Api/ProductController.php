<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all()->where('is_deleted', false);
        if($products->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'No products found'
            ]);
        }
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'quantity_total' => 'required',
            'image' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }

        $product = Product::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function update(Request $request, $id){
        
    }
}
