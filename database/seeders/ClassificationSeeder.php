<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classification;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classifications = [
            ['name' => 'Classification 1'],
            ['name' => 'Classification 2'],
            ['name' => 'Classification 3'],
        ];

        foreach ($classifications as $classification) {
            Classification::create($classification);
        }
    }
}
