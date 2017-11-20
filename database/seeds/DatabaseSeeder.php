<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(TeamsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(EmployeesTableSeeder::class);
         $this->call(TicketsTableSeeder::class);
         $this->call(TicketReadsSeeder::class);
         $this->call(TicketRelatersSeeder::class);
    }
}
