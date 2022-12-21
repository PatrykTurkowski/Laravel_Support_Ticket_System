<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Label;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user = User::inRandomOrder()->first();
        $priority = Priority::inRandomOrder()->first();
        $status = Status::inRandomOrder()->first();
        return [
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(2),
            'priority_id' => $priority->id,
            'status_id' => $status->id,
            'assigned_agent_id' => $user->id,
            'user_id' => $user->id,
        ];
    }
}