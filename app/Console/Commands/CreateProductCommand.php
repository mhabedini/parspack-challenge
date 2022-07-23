<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a product via command line';
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $productData = array();
        $productData['name'] = $this->ask('Product name');
        $productData['model'] = $this->ask('Model');
        $productData['description'] = $this->ask('Description');
        $productData['summary'] = $this->ask('Summary');
        $productData['price'] = $this->ask('Price');
        $productData['sale_price'] = $this->ask('Sale Price');

        Validator::validate($productData, (new StoreProductRequest)->rules());

        $this->productService->create($productData);
        $this->info('Product has been created successfully');
        return self::SUCCESS;
    }
}
