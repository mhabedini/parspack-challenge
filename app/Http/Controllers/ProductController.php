<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        // TODO handle pagination for product comments!
        $products = Product::with('comments')->paginate($perPage);
        return response()->json($products);
    }
}
