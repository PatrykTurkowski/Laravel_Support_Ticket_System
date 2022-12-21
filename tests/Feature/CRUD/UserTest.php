<?php

namespace Tests\Unit;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase; // refresh the database after each test

    public function testCreateUser()
    {
        $this->actingAs(User::where('role', 'admin')->first());
        // create a new user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        // check that the user was created
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
    }

    public function testReadUser()
    {
        // create a new user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        // retrieve the user from the database
        $loadedUser = User::find($user->id);

        // check that the retrieved user is correct
        $this->assertEquals($loadedUser->name, 'Test User');
        $this->assertEquals($loadedUser->email, 'test@example.com');
        $this->assertEquals($loadedUser->role, 'admin');
    }
    public function testUpdateUser()
    {
        // create a new user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        // update the user
        $user->name = 'Updated User';
        $user->email = 'updated@example.com';
        $user->role = 'admin';
        $user->save();

        // check that the user was updated
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'role' => 'admin',
        ]);
    }

    public function testDeleteUser()
    {
        // create a new user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        // delete the user
        $user->delete();

        // check that the user was deleted
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}