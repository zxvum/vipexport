<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('http://127.0.0.1:8000/all.json');
        $collect = $response->collect();


        foreach ($collect as $country) {
            $name = $country['name']['common'];
            $ru_name = $country['translations']['rus']['common'];
            $postal_code_regex = '';

            if (array_key_exists("postalCode", $country)){
                if (array_key_exists("regex", $country['postalCode'])){
                    Country::create([
                        'name' => $name,
                        'ru_name' => $ru_name,
                        'postal_code_regex' => $country['postalCode']['regex']
                    ]);
                }
                continue;
            }
        }
    }
}
