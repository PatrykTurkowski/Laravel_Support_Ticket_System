<?php

namespace Tests\Feature\Database;

use App\Models\Category;
use App\Models\Label;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TablesExistsTest extends TestCase
{
    use RefreshDatabase;
    public function test_exists_users_table()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);
        $this->afterRefreshingDatabase();
    }
    public function test_exists_categories_table()
    {
        $category = Category::factory()->create();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);
        $this->afterRefreshingDatabase();
    }
    public function test_exists_labels_table()
    {
        $label = Label::factory()->create();
        $this->assertDatabaseHas('labels', [
            'id' => $label->id
        ]);
        $this->afterRefreshingDatabase();
    }
    public function test_exists_priorities_table()
    {
        $priority = Priority::factory()->create();
        $this->assertDatabaseHas('priorities', [
            'id' => $priority->id
        ]);
        $this->afterRefreshingDatabase();
    }
    public function test_exists_statuses_table()
    {
        $status = Status::factory()->create();
        $this->assertDatabaseHas('statuses', [
            'id' => $status->id
        ]);
        $this->afterRefreshingDatabase();
    }
}