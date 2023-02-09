<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([


            UserSeeder::class,
            CategorySeeder::class,
            LabelSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            TicketSeeder::class,
            CategoryTicketSeeder::class,
            LabelTicketSeeder::class,
            CommentSeeder::class,

        ]);
    }
}