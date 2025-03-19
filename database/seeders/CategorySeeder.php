<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Laptop', 'code' => 'LPT'],
            ['name' => 'Printer', 'code' => 'PRN'],
            ['name' => 'Monitor', 'code' => 'MTR'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
