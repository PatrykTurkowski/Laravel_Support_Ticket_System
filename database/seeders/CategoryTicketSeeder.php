<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all()->pluck('id')->toArray();
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            $x = rand(0, count($categories));
            if ($x != 0) {
                $ticket->categories()->attach(array_rand(array_flip($categories), $x));
            }
        }
    }
}