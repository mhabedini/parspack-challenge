<?php

namespace App\Services;

use App\Exceptions\ProductCommentLimitationExceedException;
use App\Helpers\FileEditorCreator;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductService
{
    public function index(int $perPage): LengthAwarePaginator
    {
        // TODO handle pagination for product comments!
        return Product::with('comments')->paginate($perPage);
    }

    public function create(array $data): Model|Product
    {
        return Product::create($data);
    }

    private const USER_PRODUCT_COMMENT_LIMIT = 2;
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

        if ($user->productCommentCount($product) >= self::USER_PRODUCT_COMMENT_LIMIT) {
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
        $fileModifier = FileEditorCreator::create('/opt/myprogram/product_comments');
        $foundString = $fileModifier->find($regex);
        if ($foundString) {
            $newNumber = ++Str::of($foundString)->split('/\s/')->toArray()[1];
            $replace = "$product->name: $newNumber";
            $fileModifier->replace($regex, $replace);
        } else {
            $commentCount = "{$product->name}: 1";
            $fileModifier->append($commentCount);
        }
    }
}
