<?php

namespace Tests;

use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CategoryTicketSeeder;
use Database\Seeders\LabelSeeder;
use Database\Seeders\LabelTicketSeeder;
use Database\Seeders\PrioritySeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected User $user;
    protected User $agent;
    protected User $admin;
    protected function createUser(): User
    {
        return User::factory()->create();
    }
    protected function createAgent(): User
    {
        return User::factory()->agent()->create();
    }
    protected function createAdmin(): User
    {
        return User::factory()->admin()->create();
    }

    protected function createCategory(): Category
    {
        return Category::factory()->create();
    }
    protected function createLabel(): Label
    {
        return Label::factory()->create();
    }
    private function createTicketWithoutHasMany(array $data = null): Ticket
    {
        $this->seed([

            CategorySeeder::class,
            LabelSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            CategoryTicketSeeder::class,
            LabelTicketSeeder::class,

        ]);
        return Ticket::factory()->create($data);
    }
    protected function createTicket(array $data = null): Ticket
    {
        $ticket = $this->createTicketWithoutHasMany();

        $ticket->save();
        return Ticket::factory()->create($data);
    }

    protected function updateTicket(array $data = null): Ticket
    {

        $ticket = $this->createTicketWithoutHasMany();

        $ticket->categoryTicketLog($data['category_id']);
        $ticket->labelTicketLog($data['label_id']);
        $ticket->save();
        return Ticket::factory()->create();
    }
    protected function createSecondAgent(): User
    {
        return User::factory()->create(['role' => RoleEnum::AGENT->value]);
    }
}
