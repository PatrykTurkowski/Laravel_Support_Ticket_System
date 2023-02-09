<?php

namespace Tests\Feature;

use Faker\Provider\Lorem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->agent = $this->createAgent();
        $this->admin = $this->createAdmin();
    }

    // categories index

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_categories_page()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_categories_page()
    {
        $response = $this->actingAs($this->user)->get(route('categories.index'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_cannot_access_the_categories_page()
    {
        $response = $this->actingAs($this->agent)->get(route('categories.index'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_categories_page()
    {
        $response = $this->actingAs($this->admin)->get(route('categories.index'));
        $response->assertStatus(200);
    }



    // categories create


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_create_categories_page()
    {
        $response = $this->get(route('categories.create'));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_create_categories_page()
    {
        $response = $this->actingAs($this->agent)->get(route('categories.create'));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_create_categories_page()
    {
        $response = $this->actingAs($this->agent)->get(route('categories.create'));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_create_categories_page()
    {
        $response = $this->actingAs($this->admin)->get(route('categories.create'));
        $response->assertStatus(200);
    }


    // categories edit

    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_edit_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->get(route('categories.edit', $category));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_edit_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->get(route('categories.edit', $category));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_edit_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->get(route('categories.edit', $category));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_edit_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->admin)->get(route('categories.edit', $category));
        $response->assertStatus(200);
    }



    // categories update


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_update_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->patch(route('categories.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_update_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->patch(route('categories.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_update_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->patch(route('categories.update', $category), [
            'name' => 'Change User Name'
        ]);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_update_categories_page()
    {
        $category = $this->createCategory();

        $response = $this->actingAs($this->admin)->patch(route('categories.update', $category), [
            'name' => 'Change Category Name',

        ]);
        $this->assertDatabaseHas('categories', ['name' => 'Change Category Name']);
        $response->assertStatus(302);
        $response->assertRedirect('/categories');
    }
    public function test_as_admin_if_I_can_access_the_update_categories_page_but_with_errors_in_inputs()
    {
        $category = $this->createCategory();
        $name = ['name' => fake()->words(300)];
        $response = $this->actingAs($this->admin)->patch(route('categories.update', $category), $name);
        $this->assertDatabaseMissing('categories', $name);
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $response->assertStatus(302);
    }


    // categories store


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_store_categories_page()
    {
        $category = $this->defaultInputsForCategory();
        $response = $this->post(route('categories.store'), $category);
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_store_categories_page()
    {
        $category = $this->defaultInputsForCategory();
        $response = $this->actingAs($this->agent)->post(route('categories.store'), $category);
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_store_categories_page()
    {
        $category = $this->defaultInputsForCategory();
        $response = $this->actingAs($this->agent)->post(route('categories.store'), $category);
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_store_categories_page()
    {
        $category = $this->defaultInputsForCategory();
        $response = $this->actingAs($this->admin)->post(route('categories.store'), $category);


        $response->assertStatus(302);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'Example Category name',

        ]);
    }
    public function test_as_admin_if_I_can_access_the_store_categories_page_but_with_errors_in_inputs()
    {

        $category = [
            'name' => fake()->words(300)
        ];
        $response = $this->actingAs($this->admin)->post(route('categories.store'), $category);
        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', $category);
    }



    // categories destroy


    public function test_as_a_person_not_logged_in_if_I_cannot_access_the_destroy_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->delete(route('categories.destroy', $category));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    public function test_as_user_if_I_cannot_access_the_destroy_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->delete(route('categories.destroy', $category));
        $response->assertStatus(403);
    }
    public function test_as_agent_if_I_can_access_the_destroy_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->agent)->delete(route('categories.destroy', $category));
        $response->assertStatus(403);
    }
    public function test_as_admin_if_I_can_access_the_destroy_categories_page()
    {
        $category = $this->createCategory();
        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));


        $response->assertStatus(302);
        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', [
            'name' => 'Example User Name',
            'email' => 'example@example.com',
        ]);
    }




    private function defaultInputsForCategory()
    {
        return [
            'name' => 'Example Category name',

        ];
    }
}
