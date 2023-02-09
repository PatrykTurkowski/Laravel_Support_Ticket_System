<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => RoleEnum::USER->value,
            'password' => '$2y$10$xRAR2ckNQh3srR./6TpGHOXcTBYIbPu.A85ETH2xq4cfmV2BbA.tG', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [

                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'role' => RoleEnum::ADMIN->value,
                'password' => '$2y$10$xRAR2ckNQh3srR./6TpGHOXcTBYIbPu.A85ETH2xq4cfmV2BbA.tG',
                // password
                'remember_token' => Str::random(10),

            ];
        });
    }

    public function agent()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'agent',
                'email' => 'agent@agent.com',
                'email_verified_at' => now(),
                'role' => RoleEnum::AGENT->value,
                'password' => '$2y$10$xRAR2ckNQh3srR./6TpGHOXcTBYIbPu.A85ETH2xq4cfmV2BbA.tG',
                // password
                'remember_token' => Str::random(10),
            ];
        });
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}