<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed Emp info
     * @return void
     */
    public function run()
    {
        $password = bcrypt('test');
        
        $roles = ['member', 'sublead', 'leader'];

        Employee::create([
            'name' => 'Member HN',
            'email' => 'member_hn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 1,
            'avatar_url' => "img/$roles[0].png",
        ]);

        Employee::create([
            'name' => 'Sub-lead HN',
            'email' => 'sublead_hn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 2,
            'avatar_url' => "img/$roles[1].png",
        ]);

        Employee::create([
            'name' => 'Leader HN',
            'email' => 'leader_hn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 3,
            'avatar_url' => "img/$roles[2].png",
        ]);

        Employee::create([
            'name' => 'Member DN',
            'email' => 'member_dn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 4,
            'avatar_url' => "img/$roles[0].png",
        ]);

        Employee::create([
            'name' => 'Sub-lead DN',
            'email' => 'sublead_dn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 5,
            'avatar_url' => "img/$roles[1].png",
        ]);

        Employee::create([
            'name' => 'Leader DN',
            'email' => 'leader_dn@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => 6,
            'avatar_url' => "img/$roles[2].png",
        ]);

        Employee::create([
            'name' => 'Tester',
            'email' => 'tester@tes.t',
            'password' => $password,
            'remember_token' => str_random(10),
            'role_team_id' => null,
        ]);

        factory(Employee::class, 100)->create();

    }
}
