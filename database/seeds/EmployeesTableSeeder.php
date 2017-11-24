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
            'email' => 'member_hn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 1
        ]);

        Employee::create([
            'name' => 'Sub-lead HN',
            'email' => 'sublead_hn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 2,
        ]);

        Employee::create([
            'name' => 'Leader HN',
            'email' => 'leader_hn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 3,
        ]);

        Employee::create([
            'name' => 'Member DN',
            'email' => 'member_dn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 4,
        ]);

        Employee::create([
            'name' => 'Sub-lead DN',
            'email' => 'sublead_dn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 5,
        ]);

        Employee::create([
            'name' => 'Leader DN',
            'email' => 'leader_dn@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => 6,
        ]);

        Employee::create([
            'name' => 'Tester',
            'email' => 'tester@tes.t',
            'password' => bcrypt('test'),
            'remember_token' => str_random(10),
            'role_team_id' => null,
        ]);

        factory(Employee::class, 70)->create();

    }
}
