<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Copy;
use App\Models\Lending;
use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //fontos a sorrend!!
        User::factory(20)->create();
        Book::factory(20)->create();
        Copy::factory(20)->create();
        Lending::factory(5)->create();
        Reservation::factory(5)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}
