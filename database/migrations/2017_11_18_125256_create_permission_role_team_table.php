<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned()->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('role_team_id')->unsigned()->nullable();
            $table->foreign('role_team_id')->references('id')->on('role_team')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role_team');
    }
}
