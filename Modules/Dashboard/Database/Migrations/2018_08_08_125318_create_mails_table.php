<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->string('from');
            $table->string('to');
            $table->enum('active', ['Y', 'N'])->default("Y");
            $table->enum('with_queue', ['Y', 'N'])->default("N");
            $table->enum('sent', ['Y', 'N'])->default("N");
            $table->enum('with_content', ['Y', 'N'])->default("N");
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
        Schema::dropIfExists('mails');
    }
}
