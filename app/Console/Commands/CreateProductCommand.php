<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $productName = $this->ask('Product name');
        Product::create([
            'name' => $productName,
        ]);
        $this->info('Product has been created successfully');
        return self::SUCCESS;
    }
}