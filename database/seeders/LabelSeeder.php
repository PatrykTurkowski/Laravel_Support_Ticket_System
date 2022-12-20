<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    private $defaultlabels = [
        'bug',
        'question',
        'enhancement',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (Label::defaultLabels as $label) {
            Label::factory()->create(
                ['name' => $label]
            );
        }
    }
}