<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->agent = $this->createAgent();
        $this->admin = $this->createAdmin();
    }

    // Users index

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_users_page()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_users_page()
    {
        $response = $this->actingAs($this->user)->get(route('users.index'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_cannot_access_the_users_page()
    {
        $response = $this->actingAs($this->agent)->get(route('users.index'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_users_page()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response->assertStatus(200);
    }



    // Users create


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_create_users_page()
    {
        $response = $this->get(route('users.create'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_create_users_page()
    {
        $response = $this->actingAs($this->agent)->get(route('users.create'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_create_users_page()
    {
        $response = $this->actingAs($this->agent)->get(route('users.create'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_create_users_page()
    {
        $response = $this->actingAs($this->admin)->get(route('users.create'));
        $response->assertStatus(200);
    }


    // Users edit

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_edit_users_page()
    {
        $user = $this->createUser();
        $response = $this->get(route('users.edit', $user));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_edit_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->get(route('users.edit', $user));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_edit_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->get(route('users.edit', $user));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_edit_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->admin)->get(route('users.edit', $user));
        $response->assertStatus(200);
    }



    // Users update


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_update_users_page()
    {
        $user = $this->createUser();
        $response = $this->patch(route('users.update', $user), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_update_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->patch(route('users.update', $user), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_update_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->patch(route('users.update', $user), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_update_users_page()
    {
        $user = $this->createUser();

        $response = $this->actingAs($this->admin)->patch(route('users.update', $user), [
            'name' => 'Change User Name',
            'email' => $user->email,
            'role' => $user->role
        ]);
        $this->assertDatabaseHas('users', ['name' => 'Change User Name']);
        $response->assertStatus(302);
        $response->assertRedirect('/users');
    }
    public function test_as_admin_if_I_can_access_the_update_users_page_but_with_errors_in_inputs()
    {
        $user = $this->createUser();

        $response = $this->actingAs($this->admin)->patch(route('users.update', $user), [
            'name' => 'Change User Name',
            'email' => '',
            'role' => $user->role
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'Change User Name',
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }


    // Users store


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_store_users_page()
    {
        $user = $this->createUserForUserCreator();
        $response = $this->post(route('users.store'), $user);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_store_users_page()
    {
        $user = $this->createUserForUserCreator();
        $response = $this->actingAs($this->agent)->post(route('users.store'), $user);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_store_users_page()
    {
        $user = $this->createUserForUserCreator();
        $response = $this->actingAs($this->agent)->post(route('users.store'), $user);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_store_users_page()
    {
        $user = $this->createUserForUserCreator();
        $response = $this->actingAs($this->admin)->post(route('users.store'), $user);


        $response->assertStatus(302);
        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }
    public function test_as_admin_if_I_can_access_the_store_users_page_but_with_errors_in_inputs()
    {
        $user = [
            'Example User Name',
            'email' => 'example@example.com',
            'role' => RoleEnum::USER->value,
            'password' => 'Secret11',

        ];
        $response = $this->actingAs($this->admin)->post(route('users.store'), $user);
        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }



    // Users destroy


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_destroy_users_page()
    {
        $user = $this->createUser();
        $response = $this->delete(route('users.destroy', $user));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_destroy_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->delete(route('users.destroy', $user));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_destroy_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->agent)->delete(route('users.destroy', $user));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_destroy_users_page()
    {
        $user = $this->createUser();
        $response = $this->actingAs($this->admin)->delete(route('users.destroy', $user));


        $response->assertStatus(302);
        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }




    private function createUserForUserCreator()
    {
        return [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
            'role' => RoleEnum::USER->value,
            'password' => 'Secret11',
            'password_confirmation' => 'Secret11',
        ];
    }
}
