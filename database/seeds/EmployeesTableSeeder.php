<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Employee::create([
            'name' => 'Member HN',
            'email' => 'mem_hn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 1,
            'role_id' => 1
        ]);

        Employee::create([
            'name' => 'Sub-lead HN',
            'email' => 'sl_hn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 1,
            'role_id' => 2
        ]);

        Employee::create([
            'name' => 'Leader HN',
            'email' => 'leader_hn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 1,
            'role_id' => 3
        ]);

        Employee::create([
            'name' => 'Member DN',
            'email' => 'mem_dn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 2,
            'role_id' => 1
        ]);

        Employee::create([
            'name' => 'Sub-lead DN',
            'email' => 'sl_dn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 2,
            'role_id' => 2
        ]);

        Employee::create([
            'name' => 'Leader DN',
            'email' => 'leader_dn@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => 2,
            'role_id' => 3
        ]);

        Employee::create([
            'name' => 'Tester',
            'email' => 'tester@test.er',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'team_id' => null,
            'role_id' => null
        ]);

        factory(Employee::class, 50)->create();

    }
}
