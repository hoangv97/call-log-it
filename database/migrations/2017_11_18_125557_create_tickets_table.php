<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('content');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('priority');
            $table->dateTime('deadline');
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('cascade');
            $table->tinyInteger('rating')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->dateTime('resolved_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
