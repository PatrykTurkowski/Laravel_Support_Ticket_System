<?php

namespace Tests\Feature\Database;

use App\Models\Category;
use App\Models\Label;
use App\Models\Priority;
use App\Models\Status;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;



    public function test_exists_default_rows_in_labels_table_after_seed()
    {

        $this->assertDatabaseCount('labels', count(Label::defaultLabels));
        foreach (Label::defaultLabels as $key => $label) {
            $this->assertDatabaseHas('labels', [
                'id' => $key + 1,
                'name' => $label
            ]);
        }
    }
    public function test_exists_default_rows_in_statuses_table_after_seed()
    {

        $this->assertDatabaseCount('statuses', count(Status::defaultStatuses));
        foreach (Status::defaultStatuses as $key => $status) {
            $this->assertDatabaseHas('statuses', [
                'id' => $key + 1,
                'name' => $status
            ]);
        }
    }
    public function test_exists_default_rows_in_priorities_table_after_seed()
    {
        $this->assertDatabaseCount('priorities', count(Priority::defaultPriorities));
        foreach (Priority::defaultPriorities as $key => $priority) {
            $this->assertDatabaseHas('priorities', [
                'id' => $key + 1,
                'name' => $priority
            ]);
        }
    }
    public function test_exists_default_rows_in_categories_table_after_seed()
    {
        $this->assertDatabaseCount('categories', count(Category::defaultCategories));
        foreach (Category::defaultCategories as $key => $category) {
            $this->assertDatabaseHas('categories', [
                'id' => $key + 1,
                'name' => $category
            ]);
        }
    }
}