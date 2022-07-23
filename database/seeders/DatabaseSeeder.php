<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'username' => 'parspack',
            'email' => 'admin@parspack.com',
            'password' => Hash::make('#LAer&12*ONGsTr'),
        ]);

        Product::factory()->create([
            'name' => 'A'
        ]);

        Product::factory()->create([
            'name' => 'B'
        ]);

        Product::factory()->create([
            'name' => 'C'
        ]);
    }
}
