<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCommentRequest;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductCommentController extends Controller
{
    /**
     * @throws \Exception
     */
    public function store(StoreProductCommentRequest $request, ProductService $productService)
    {
        $user = auth('api')->user();
        $commentData = $request->safe()->except(['product_name']);
        $productName = $request->input('product_name');
        $comment = $productService->addComment($productName, $user, $commentData);
        return response()->json($comment, Response::HTTP_CREATED);
    }
}
