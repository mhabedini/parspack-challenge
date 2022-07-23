<?php

namespace App\Services;

use App\Exceptions\ProductCommentLimitationExceedException;
use App\Helpers\FileModifierFactory;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductService
{
    public function index(int $perPage): LengthAwarePaginator
    {
        // TODO handle pagination for product comments!
        return Product::with('comments')->paginate($perPage);
    }

    /**
     * @throws \Exception
     */
    public function addComment(string $productName, User $user, array $commentData): Comment
    {
        $productExists = Product::where('name', $productName)->exists();

        if (!$productExists) {
            $product = Product::create([
                'name' => $productName,
            ]);
        } else {
            $product = Product::whereName($productName)->first();
        }

        if ($user->productCommentCount($product) >= 2) {
            throw new ProductCommentLimitationExceedException();
        }

        return $product->comments()->create(
            $commentData + ['user_id' => $user->id]
        );
    }

    public function increaseCommentCount(Comment $comment): void
    {
        $product = Product::findOrFail($comment->commentable_id);
        $regex = "{$product->name}: [0-9]+";
        $fileModifier = FileModifierFactory::create('/opt/myprogram/product_comments');
        $found = $fileModifier->find($regex);
        if ($found) {
            $newNumber = ++Str::of($found)->split('/\s/')->toArray()[1];
            $replace = "$product->name: $newNumber";
            $fileModifier->replace($regex, $replace);
        } else {
            $commentCount = "{$product->name}: 1";
            $fileModifier->append($commentCount);
        }
    }
}
