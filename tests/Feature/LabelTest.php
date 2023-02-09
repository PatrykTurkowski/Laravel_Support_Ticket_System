<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->agent = $this->createAgent();
        $this->admin = $this->createAdmin();
    }

    // labels index

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_labels_page()
    {
        $response = $this->get(route('labels.index'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_labels_page()
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_cannot_access_the_labels_page()
    {
        $response = $this->actingAs($this->agent)->get(route('labels.index'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_labels_page()
    {
        $response = $this->actingAs($this->admin)->get(route('labels.index'));
        $response->assertStatus(200);
    }



    // labels create


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_create_labels_page()
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_create_labels_page()
    {
        $response = $this->actingAs($this->agent)->get(route('labels.create'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_create_labels_page()
    {
        $response = $this->actingAs($this->agent)->get(route('labels.create'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_create_labels_page()
    {
        $response = $this->actingAs($this->admin)->get(route('labels.create'));
        $response->assertStatus(200);
    }


    // labels edit

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_edit_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->get(route('labels.edit', $category));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_edit_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->get(route('labels.edit', $category));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_edit_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->get(route('labels.edit', $category));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_edit_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->admin)->get(route('labels.edit', $category));
        $response->assertStatus(200);
    }



    // labels update


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_update_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->patch(route('labels.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_update_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->patch(route('labels.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_update_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->patch(route('labels.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_update_labels_page()
    {
        $category = $this->createLabel();

        $response = $this->actingAs($this->admin)->patch(route('labels.update', $category), [
            'name' => 'Change Category Name',

        ]);
        $this->assertDatabaseHas('labels', ['name' => 'Change Category Name']);
        $response->assertStatus(302);
        $response->assertRedirect('/labels');
    }
    public function test_as_admin_if_I_can_access_the_update_labels_page_but_with_errors_in_inputs()
    {
        $category = $this->createLabel();
        $name = ['name' => fake()->words(300)];
        $response = $this->actingAs($this->admin)->patch(route('labels.update', $category), $name);
        $this->assertDatabaseMissing('labels', $name);
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }


    // labels store


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_store_labels_page()
    {
        $category = $this->defaultInputsForLabel();
        $response = $this->post(route('labels.store'), $category);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_store_labels_page()
    {
        $category = $this->defaultInputsForLabel();
        $response = $this->actingAs($this->agent)->post(route('labels.store'), $category);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_store_labels_page()
    {
        $category = $this->defaultInputsForLabel();
        $response = $this->actingAs($this->agent)->post(route('labels.store'), $category);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_store_labels_page()
    {
        $category = $this->defaultInputsForLabel();
        $response = $this->actingAs($this->admin)->post(route('labels.store'), $category);


        $response->assertStatus(302);
        $response->assertRedirect('/labels');
        $this->assertDatabaseHas('labels', [
            'name' => 'Example Category name',

        ]);
    }
    public function test_as_admin_if_I_can_access_the_store_labels_page_but_with_errors_in_inputs()
    {
        $name = ['name' => fake()->words(300)];
        $response = $this->actingAs($this->admin)->post(route('labels.store'), $name);
        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertDatabaseMissing('labels', $name);
    }



    // labels destroy


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_destroy_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->delete(route('labels.destroy', $category));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_destroy_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->delete(route('labels.destroy', $category));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_destroy_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->agent)->delete(route('labels.destroy', $category));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_destroy_labels_page()
    {
        $category = $this->createLabel();
        $response = $this->actingAs($this->admin)->delete(route('labels.destroy', $category));


        $response->assertStatus(302);
        $response->assertRedirect('/labels');
        $this->assertDatabaseMissing('labels', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }




    private function defaultInputsForLabel()
    {
        return [
            'name' => 'Example Category name',
        ];
    }
}
