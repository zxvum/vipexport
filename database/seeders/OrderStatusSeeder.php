<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Создан, ждет добавления товаров', 'hex' => '#000000', 'order_number' => 1, 'custom_props' => 'default'],
            ['name' => 'Сформирован, ждет подтверждения', 'hex' => '#000000', 'order_number' => 2],
            ['name' => 'В обработке, есть вопрос', 'hex' => '#000000', 'order_number' => 3],
            ['name' => 'Заказ ждет подтверждения', 'hex' => '#000000', 'order_number' => 4],
            ['name' => 'В ожидании вашей оплаты', 'hex' => '#000000', 'order_number' => 5],
            ['name' => 'Отменен', 'hex' => '#000000', 'order_number' => 6],
            ['name' => 'Идет процесс покупки', 'hex' => '#000000', 'order_number' => 7],
            ['name' => 'В ожидании отправления на склад', 'hex' => '#000000', 'order_number' => 8],
            ['name' => 'В процессе, мы работает над заказом', 'hex' => '#000000', 'order_number' => 9],
            ['name' => 'Прибыл на склад', 'hex' => '#000000', 'order_number' => 10],
            ['name' => 'Добавлен в поссылку', 'hex' => '#000000', 'order_number' => 11],
            ['name' => 'Упакован', 'hex' => '#000000', 'order_number' => 12],
            ['name' => 'Отправлен в поссылке', 'hex' => '#000000', 'order_number' => 13],
            ['name' => 'Доставлен клиенту', 'hex' => '#000000', 'order_number' => 14],
            ['name' => 'Не получен/В ожидании возврата', 'hex' => '#000000', 'order_number' => 15],
        ];

        foreach ($statuses as $key => $status) {
            OrderStatus::create([
                'name' => $status['name'],
                'hex' => $status['hex'],
                'order' => $key + 1
            ]);
        }
    }
}
