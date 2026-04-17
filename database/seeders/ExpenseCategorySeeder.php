<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Seed expense categories.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bahan Baku', 'description' => null],
            ['name' => 'Operasional', 'description' => null],
            ['name' => 'Gaji Karyawan', 'description' => null],
            ['name' => 'Sewa Tempat', 'description' => null],
            ['name' => 'Listrik & Air', 'description' => null],
            ['name' => 'Peralatan', 'description' => null],
            ['name' => 'Transportasi', 'description' => null],
            ['name' => 'Lain-lain', 'description' => null],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
