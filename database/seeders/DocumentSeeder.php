<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::create([
            'name' => 'Скан паспорта',
            'is_active' => true,
            'order' => 1
        ]);

        Document::create([
            'name' => 'Скан договора',
            'template_file' => 'terms-buyusa-mf.pdf',
            'example_file' => 'MFdogovor.png',
            'is_active' => true,
            'order' => 2
        ]);
        Document::create([
            'name' => 'Скан формы 1583',
            'template_file' => 'ps1583orig.pdf',
            'example_file' => 'MF1583.png',
            'is_active' => true,
            'order' => 3
        ]);
    }
}
