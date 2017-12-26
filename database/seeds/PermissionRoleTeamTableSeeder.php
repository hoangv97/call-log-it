<?php

use App\Facade\Constant;
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

        $teams = [null, $hanoiTeam, $danangTeam];

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

        $roles = [null, $memberRole, $subleadRole, $leaderRole];

        //RoleTeam
        for($i = 1; $i <= 2; $i++) {
            for($j = 1; $j <= 3; $j++) {
                RoleTeam::create([
                    'name' => $roles[$j]->name." ".$teams[$i]->name,
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
            Constant::PERMISSION_MANAGE_TICKET_PERSON  => [1, 4],
            Constant::PERMISSION_MANAGE_TICKET_TEAM    => [3, 5],
            Constant::PERMISSION_MANAGE_TICKET_COMPANY => [6],
            Constant::PERMISSION_VIEW_TICKET_TEAM      => [2, 5, 6],
            Constant::PERMISSION_VIEW_TICKET_COMPANY   => [3]
        ];
        foreach ($prts as $prt => $rt_ids) {
            foreach ($rt_ids as $rt_id) {
                PermissionRoleTeam::create([
                    'permission_id' => $prt,
                    'role_team_id' => $rt_id
                ]);
            }
        }

    }
}
