<?php

namespace Database\Seeders;

use App\Models\Country;
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
            'password' => Hash::make('timtimtim'),
            'country_id' => Country::all()->first()->id,
            'city' => 'Kropotkin',
            'phone_number' => 89181243115,
            'balance' => 30
        ]);
    }
}
