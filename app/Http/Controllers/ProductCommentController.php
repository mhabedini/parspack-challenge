<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCommentRequest;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductCommentController extends Controller
{
    /**
     * @throws \Exception
     */
    public function store(StoreProductCommentRequest $request)
    {
        $productExists = Product::where('name', $request->input('product_name'))->exists();

        if (!$productExists) {
            $product = Product::create([
                'name' => $request->input('product_name'),
            ]);
        } else {
            $product = Product::whereName($request->input('product_name'))->first();
        }

        $user = auth('api')->user();

        if ($user->productCommentCount($product) >= 2) {
            throw new \Exception();
        }

        $comment = $product->comments()->create(
            $request->safe()->except(['product_name']) + ['user_id' => $user->id]
        );

        return response()->json($comment, Response::HTTP_CREATED);
    }
}
