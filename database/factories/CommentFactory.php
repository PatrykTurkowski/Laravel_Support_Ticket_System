<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        $ticket = Ticket::inRandomOrder()->first();
        if (rand(0, 1) == 1) {
            $user = $ticket->user_id;
        } else {
            $user = $ticket->assigned_agent_id;
        }
        return [
            'content' => fake()->sentence(2),
            'ticket_id' => $ticket->id,
            'user_id' => $user
        ];
    }
}