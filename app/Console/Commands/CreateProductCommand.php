<?php

namespace App\Console\Commands;

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
        $productName = $this->ask('Product name');
        Validator::validate(['name' => $productName], ['name' => 'required|string|unique:products']);
        $this->productService->create([
            'name' => $productName,
        ]);
        $this->info('Product has been created successfully');
        return self::SUCCESS;
    }
}
