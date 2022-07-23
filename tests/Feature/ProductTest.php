<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanGetListOfProducts()
    {
        Product::factory()->count(10)->create();
        $response = $this->get("api/products?page=2&per_page=4");
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [[
                'id',
                'name',
                'model',
                'description',
                'summary',
                'price',
                'sale_price',
            ]]
        ]);
    }
}
