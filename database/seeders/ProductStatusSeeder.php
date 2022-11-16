<?php

namespace Database\Seeders;

use App\Models\OrderProductStatus;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Добавлен в заказ',
            'В обработке',
            'Заказ ждет подтверждения',
            'Отменен',
            'Подтвержден, в обработке',
            'Сформирован, ждет оплаты',
            'Куплен, ожидает прибытие на склад',
            'Прибыл на склад',
            'Добавлен в поссылку'
        ];

        foreach ($statuses as $key => $status) {
            OrderProductStatus::create([
                'name' => $status,
                'hex' => '#000000',
                'order' => $key + 1
            ]);
        }
    }
}
