<?php

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCommentOnProduct()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $product = Product::factory()->create();
        $comment = Comment::factory()->raw();
        $response = $this->post('api/products/comments', [
            'title' => $comment['title'],
            'product_name' => $product['name'],
            'description' => $comment['description'],
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'title',
            'description',
            'user_id',
            'commentable_id',
            'commentable_type',
            'id',
        ]);

        $response->assertJson([
            'title' => $comment['title'],
            'description' => $comment['description'],
            'user_id' => $user->id,
        ]);
    }

    public function testUserCantAddMoreThanTwoCommentsOnAProduct()
    {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $product = Product::factory()->create();
        $comment = Comment::factory()->raw();
        $response = $this->post('api/products/comments', [
            'title' => $comment['title'],
            'product_name' => $product['name'],
            'description' => $comment['description'],
        ]);
        $response->assertCreated();
        $response = $this->post('api/products/comments', [
            'title' => $comment['title'],
            'product_name' => $product['name'],
            'description' => $comment['description'],
        ]);
        $response->assertCreated();
        $this->post('api/products/comments', [
            'title' => $comment['title'],
            'product_name' => $product['name'],
            'description' => $comment['description'],
        ]);
    }
}
