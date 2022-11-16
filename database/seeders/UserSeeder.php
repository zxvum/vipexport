<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Count;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'tim',
            'surname' => 'vash',
            'email' => 'timvash90@gmail.com',
            'password' => Hash::make('timtim'),
            'country_id' => Country::all()->first()->id,
            'city' => 'Kropotkin',
            'phone_number' => 89181243115,
            'balance' => 30
        ]);

        Address::create([
            'user_id' => $user->id,
            'name' => 'Тимур',
            'surname' => 'Ващенко',
            'country_id' => Country::where('name', 'Russia')->first()->id,
            'region' => 'Краснодарский край',
            'city' => 'Кропоткин',
            'postal_code' => 352380,
            'street' => 'Красная 250',
            'phone_number' => 89181243115,
            'email' => $user->email
        ]);

        $iphone_order = Order::create([
            'user_id' => $user->id,
            'status_id' => 1,
            'name' => 'Заказ айфонов'
        ]);

        OrderProduct::create([
            'order_id' => $iphone_order->id,
            'status_id' => 1,
            'shop_id' => 1,
            'link' => 'https://www.mvideo.ru/products/smartfon-apple-iphone-13-128gb-midnight-mlnw3ru-a-30059036',
            'title' => 'Смартфон Apple iPhone 13 128GB Midnight',
            'price' => 59990,
            'quantity' => 2
        ]);

        OrderProduct::create([
            'order_id' => $iphone_order->id,
            'status_id' => 1,
            'shop_id' => 2,
            'link' => 'https://www.ebay.com/itm/385234191069',
            'title' => 'Apple iPhone 14 Pro Max 128GB eSim Special Edition Factory Unlocked Super Sconto',
            'price' => 88034.07,
            'quantity' => 1
        ]);

        OrderProduct::create([
            'order_id' => $iphone_order->id,
            'status_id' => 1,
            'shop_id' => 2,
            'link' => 'https://www.ebay.com/itm/385234191069',
            'title' => 'Apple iPhone 14 Pro 256GB eSim Special Edition Factory Unlocked Super Sconto',
            'price' => 88034.07,
            'quantity' => 4
        ]);

        $google_order = Order::create([
            'user_id' => $user->id,
            'status_id' => 1,
            'name' => 'Заказ пикселей'
        ]);

        OrderProduct::create([
            'order_id' => $google_order->id,
            'status_id' => 1,
            'shop_id' => 4,
            'link' => 'https://google.com',
            'title' => 'Google Pixel 7 Pro 512/12 Black',
            'price' => 70000,
            'quantity' => 2
        ]);
    }
}
