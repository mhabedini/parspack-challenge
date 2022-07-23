<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Product;
use App\Services\ProductService;

class CommentObserver
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function created(Comment $comment): void
    {
        if ($comment->commentable_type == Product::class) {
            $this->productService->increaseCommentCount($comment);
        }
    }
}
