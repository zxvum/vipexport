<?php

namespace Database\Seeders;

use App\Models\UserDocumentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Документ не загружен', 'hex' => '#000000'],
            ['name' => 'Ожидает проверки', 'hex' => '#ffc107'],
            ['name' => 'Подтвержден', 'hex' => '#198754'],
            ['name' => 'Отклонен', 'hex' => '#dc3545'],
        ];

        foreach ($statuses as $key => $status) {
            UserDocumentStatus::create([
                'name' => $status['name'],
                'hex' => $status['hex'],
                'order' => $key + 1
            ]);
        }
    }
}
