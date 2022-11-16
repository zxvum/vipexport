<?php

namespace Database\Seeders;

use App\Models\OrderProductShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderProductShop::create([
            'name' => 'Ebay',
            'order' => 1
        ]);
        OrderProductShop::create([
            'name' => 'Amazon',
            'order' => 2
        ]);
        OrderProductShop::create([
            'name' => 'Apple',
            'order' => 3
        ]);
        OrderProductShop::create([
            'name' => 'Walmart',
            'order' => 4
        ]);
        OrderProductShop::create([
            'name' => 'Best Buy',
            'order' => 5
        ]);
    }
}
