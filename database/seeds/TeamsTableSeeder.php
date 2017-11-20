<?php

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'name' => 'IT Hà Nội'
        ]);

        Team::create([
            'name' => 'IT Đà Nẵng'
        ]);
    }
}
