<?php

namespace App\Observers;

use App\Enums\ProductCommentsCount;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Str;

class CommentObserver
{
    public function created(Comment $comment)
    {
        if ($comment->commentable_type == Product::class) {
            $product = Product::find($comment->commentable_id);
            $dir = ProductCommentsCount::FILE_DIR;
            $path = ProductCommentsCount::FILE_PATH;
            $fileExists = exec("test -e $path && echo exists || echo ");
            if (empty($fileExists)) {
                exec("sudo mkdir -p $dir");
                exec("sudo touch $path");
            }
            $regex = "{$product->name}: [0-9]+";
            $found = exec("grep -E '$regex' $path");
            if ($found) {
                $newNumber = ++Str::of($found)->split('/\s/')->toArray()[1];
                $replace = "$product->name: $newNumber";
                exec("sed -i -E 's/$regex/$replace/g' $path");
            } else {
                exec("echo '{$product->name}: 1' >> $path");
            }
        }
    }
}
