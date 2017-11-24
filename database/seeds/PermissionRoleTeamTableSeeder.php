<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\RoleTeam;
use App\Models\PermissionRoleTeam;
use Illuminate\Database\Seeder;

class PermissionRoleTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Teams
        $hanoiTeam = new Team;
        $hanoiTeam->name = 'IT Hà Nội';
        $hanoiTeam->save();

        $danangTeam = new Team;
        $danangTeam->name = 'IT Đà Nẵng';
        $danangTeam->save();

        $teams = [$hanoiTeam, $danangTeam];

        //Roles
        $memberRole = new Role;
        $memberRole->name = 'Member';
        $memberRole->save();

        $subleadRole = new Role;
        $subleadRole->name = 'Sub-lead';
        $subleadRole->save();

        $leaderRole = new Role;
        $leaderRole->name = 'Leader';
        $leaderRole->save();

        $roles = [$memberRole, $subleadRole, $leaderRole];

        //RoleTeam
        for($i = 1; $i <= 2; $i++) {
            for($j = 1; $j <= 3; $j++) {
                RoleTeam::create([
                    'name' => $roles[$j-1]->name." ".$teams[$i-1]->name,
                    'team_id' => $i,
                    'role_id' => $j
                ]);
            }
        }

        //Permissions
        $p = ['manage', 'view'];
        $desc = ['person', 'team', 'company'];
        for($i = 1; $i <= 5; $i++) {
            Permission::create([
                'name' => ($i <= 3 ? $p[0] : $p[1]).'-requests-'.($i <= 3 ? $i : $i - 2),
                'description' => ucfirst($i <= 3 ? $p[0] : $p[1]).' Requests In '.ucfirst($desc[($i <= 3 ? $i-1 : $i-3)])
            ]);
        }

        //PermissionRoleTeam
        $prts = [
            [1, 1], [1, 4],
            [2, 3], [2, 5],
            [3, 6],
            [4, 2], [4, 5], [4, 6],
            [5, 3]
        ];
        foreach ($prts as $prt) {
            PermissionRoleTeam::create([
                'permission_id' => $prt[0],
                'role_team_id' => $prt[1]
            ]);
        }

    }
}
