<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'BAHAN BASAH', 'code' => 'BB'],
            ['name' => 'BAHAN KERING', 'code' => 'BK'], 
            ['name' => 'BAHAN PENOLONG', 'code' => 'BP'],
        ];

        foreach ($items as $item) {
            Category::create([
                'name' => $item['name'],
                'code' => $item['code'],
                'slug' => strtolower(str_replace(' ', '-', $item['name'])),
            ]);
        }
    }
}
