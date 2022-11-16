<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Ожидает действий', 'hex' => '#000000'],
            ['name' => 'Ждет подтверждения', 'hex' => '#000000'],
        ];

        foreach ($statuses as $status){
            PackageStatus::create([
                'name' => $status['name'],
                'hex' => $status['hex']
            ]);
        }
    }
}
