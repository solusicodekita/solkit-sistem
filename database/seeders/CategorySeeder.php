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
            'BAHAN BASAH',
            'BAHAN KERING',
            'BAHAN PENOLONG',
        ];

        foreach ($items as $item) {
            Category::create([
                'name' => $item,
                'slug' => Str::slug($item),
            ]);
        }
    }
}
