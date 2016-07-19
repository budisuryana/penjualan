<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appmenu', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->string('description', 35);
            $table->string('menu_url', 150)->nullable();
            $table->string('menu_alias', 150)->nullable();
            $table->enum('ismenu', ['N','Y'])->default('N');

            $table->integer('parent')->unsigned()->nullable();
            $table->foreign('parent')->references('menu_id')->on('appmenu')->onUpdate('cascade');

            $table->string('menu_icon', 20)->nullable();
            $table->smallInteger('menu_order')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('menu_url');
            $table->index('menu_alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appmenu');
    }
}
