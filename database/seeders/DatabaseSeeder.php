<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'price' => 85000,
            'stock' => 10,
        ]);

        Book::create([
            'title' => 'Bumi',
            'author' => 'Tere Liye',
            'price' => 90000,
            'stock' => 8,
        ]);

        Book::create([
            'title' => 'Filosofi Teras',
            'author' => 'Henry Manampiring',
            'price' => 95000,
            'stock' => 5,
        ]);
    }
}