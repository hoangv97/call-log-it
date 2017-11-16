<?php

use App\Team;
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
            'id' => 0,
            'name' => 'IT Hà Nội'
        ]);

        Team::create([
            'id' => 1,
            'name' => 'IT Đà Nẵng'
        ]);
    }
}
