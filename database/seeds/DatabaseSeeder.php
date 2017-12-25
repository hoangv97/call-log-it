<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder
     * @return void
     */
    public function run()
    {
         $this->call(PermissionRoleTeamTableSeeder::class);
         $this->call(EmployeesTableSeeder::class);
         $this->call(TicketsTableSeeder::class);
        $this->call(TicketRelatersSeeder::class);
        $this->call(TicketReadsSeeder::class);
        $this->call(ThreadTableSeeder::class);
    }
}
