<?php

namespace Database\Seeders;

use App\Models\Label;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = Label::all()->pluck('id')->toArray();
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            $x = rand(0, count($labels));
            if ($x != 0) {
                $ticket->labels()->attach(array_rand(array_flip($labels), $x));
            }
        }
    }
}