<?php

use App\Models\Role;
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
            'name' => 'Member'
        ]);

        Role::create([
            'name' => 'Sub-lead'
        ]);

        Role::create([
            'name' => 'Leader'
        ]);
    }
}
