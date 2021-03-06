<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->default(0);
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->enum('route_id_parameter', ['Y', 'N'])->default("Y");
            $table->enum('admin', ['Y', 'N'])->default("N");
            //$table->integer('sortorder')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
