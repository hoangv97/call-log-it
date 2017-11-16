<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'Member',
            'display_name' => 'Member',
            'description' => ''
        ]);

        Role::create([
            'id' => 2,
            'name' => 'Sub-lead',
            'display_name' => 'Sub-lead',
            'description' => ''
        ]);

        Role::create([
            'id' => 3,
            'name' => 'Leader',
            'display_name' => 'Leader',
            'description' => ''
        ]);
    }
}
