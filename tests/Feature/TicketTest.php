<?php

namespace Tests\Feature;

use App\Models\CategoryTicket;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CategoryTicketSeeder;
use Database\Seeders\LabelSeeder;
use Database\Seeders\LabelTicketSeeder;
use Database\Seeders\PrioritySeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->agent = $this->createAgent();
        $this->admin = $this->createAdmin();
    }

    // tickets index

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_tickets_page()
    {
        $response = $this->get(route('tickets.index'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_can_access_the_tickets_page()
    {
        $response = $this->actingAs($this->user)->get(route('tickets.index'));
        $response->assertStatus(200);
    }
    public function test_as_agent_if_I_can_access_the_tickets_page()
    {
        $response = $this->actingAs($this->agent)->get(route('tickets.index'));
        $response->assertStatus(200);
    }
    public function test_as_admin_if_I_can_access_the_tickets_page()
    {
        $response = $this->actingAs($this->admin)->get(route('tickets.index'));
        $response->assertStatus(200);
    }



    // tickets create


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_create_tickets_page()
    {
        $response = $this->get(route('tickets.create'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_can_access_the_create_tickets_page()
    {
        $response = $this->actingAs($this->user)->get(route('tickets.create'));
        $response->assertStatus(200);
    }
    public function test_as_agent_if_I_can_access_the_create_tickets_page()
    {
        $response = $this->actingAs($this->agent)->get(route('tickets.create'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_create_tickets_page()
    {
        $response = $this->actingAs($this->admin)->get(route('tickets.create'));
        $response->assertStatus(200);
    }


    // tickets edit

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_edit_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->get(route('tickets.edit', $ticket));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_edit_tickets_page()
    {
        $ticket = $this->createTicket(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('tickets.edit', $ticket));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_edit_tickets_page()
    {
        $this->createSecondAgent();
        $ticket = $this->createTicket([
            'user_id' => $this->user->id,
            'assigned_agent_id' => $this->agent
        ]);

        $response = $this->actingAs($this->agent)->get(route('tickets.edit', $ticket));
        $response->assertStatus(200);
    }
    public function test_as_agent_if_I_cannot_access_the_edit_tickets_page()
    {
        $agent = $this->createSecondAgent();
        $this->createSecondAgent();
        $ticket = $this->createTicket([
            'user_id' => $this->user->id,
            'assigned_agent_id' => $agent
        ]);

        $response = $this->actingAs($this->agent)->get(route('tickets.edit', $ticket));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_edit_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->actingAs($this->admin)->get(route('tickets.edit', $ticket));
        $response->assertStatus(200);
    }



    // tickets update


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_update_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->patch(route('tickets.update', $ticket), [
            'title' => 'Change title'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_update_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->actingAs($this->user)->patch(route('tickets.update', $ticket), [
            'title' => 'Change title'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_update_tickets_page()
    {
        $ticket = $this->updateTicket(
            $this->defaultInputsForTicket()

        );
        $changeInpunt = $this->defaultInputsForTicket();
        $changeInpunt['title'] = 'Change title news';


        // dd($ticket->categoryTicketTest()->get()->toArray());

        $response = $this->actingAs($this->admin)->patch(route('tickets.update', $ticket->id), $changeInpunt);
        $this->assertDatabaseHas('tickets', [
            'title' => 'Change title news',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('tickets.index'));
    }
    public function test_as_admin_if_I_can_access_the_update_tickets_page()
    {
        $ticket = $this->updateTicket(
            $this->defaultInputsForTicket()

        );
        $changeInpunt = $this->defaultInputsForTicket();
        $changeInpunt['title'] = 'Change title news';

        $response = $this->actingAs($this->admin)->patch(route('tickets.update', $ticket), $changeInpunt);
        $this->assertDatabaseHas('tickets', ['title' => 'Change title news']);
        $response->assertStatus(302);
        $response->assertRedirect('/tickets');
    }
    public function test_as_admin_if_I_can_access_the_update_tickets_page_but_with_errors_in_inputs()
    {
        $ticket = $this->createTicket();
        $Lorem = fake()->words(300);
        $response = $this->actingAs($this->admin)->patch(route('tickets.update', $ticket), [
            'name' => $Lorem,

        ]);
        $this->assertDatabaseMissing('tickets', [
            'name' => $Lorem,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }


    // tickets store


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_store_tickets_page()
    {
        $ticket = $this->defaultInputsForTicket();
        $response = $this->post(route('tickets.store'), $ticket);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_store_tickets_page()
    {
        $ticket = $this->defaultInputsForTicket();
        $response = $this->actingAs($this->agent)->post(route('tickets.store'), $ticket);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_store_tickets_page()
    {
        $ticket = $this->defaultInputsForTicket();
        $response = $this->actingAs($this->agent)->post(route('tickets.store'), $ticket);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_store_tickets_page()
    {
        $this->seed([

            CategorySeeder::class,
            LabelSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            CategoryTicketSeeder::class,
            LabelTicketSeeder::class,

        ]);
        $ticket =
            [
                "title" => "Dynamic Brand Supervisor",
                "description" => "Quos rerum explicabo nulla est ratione accusamus unde.",
                "label_id" => [
                    0 => "1",
                    1 => "2",
                    2 => "3"
                ],
                "category_id" => [
                    0 => "1",
                    1 => "3"
                ],
                "priority_id" => "3"
            ];

        $response = $this->actingAs($this->admin)->post(route('tickets.store'), $ticket);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tickets', [
            'title' => 'Dynamic Brand Supervisor',

        ]);
    }
    public function test_as_admin_if_I_can_access_the_store_tickets_page_but_with_errors_in_inputs()
    {
        $Lorem = fake()->words(300);
        $ticket = [
            'title' => $Lorem,
        ];
        $response = $this->actingAs($this->admin)->post(route('tickets.store'), $ticket);
        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertDatabaseMissing('tickets', [
            'title' => $Lorem,

        ]);
    }



    // tickets destroy


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_destroy_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->delete(route('tickets.destroy', $ticket));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_destroy_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->actingAs($this->agent)->delete(route('tickets.destroy', $ticket));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_destroy_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->actingAs($this->agent)->delete(route('tickets.destroy', $ticket));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_destroy_tickets_page()
    {
        $ticket = $this->createTicket();
        $response = $this->actingAs($this->admin)->delete(route('tickets.destroy', $ticket));


        $response->assertStatus(302);
        $response->assertRedirect('/tickets');
        $this->assertDatabaseMissing('tickets', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }




    private function defaultInputsForTicket()
    {

        return [
            "user_id" => 1,
            "title" => "Investor Metrics Liaison",
            "description" => "Eum quibusdam voluptates.",
            "label_id" => [
                "0" => "1",
                "1" => "2"
            ], 'assigned_agent_id' => $this->agent->id,
            "category_id" => [
                "0" => "1",
                "1" => "2"
            ],
            "priority_id" => "1",

        ];
    }
}
