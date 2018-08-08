<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('website_name')->nullable();
            $table->enum('google_map', ['Y', 'N'])->default("N");
            $table->enum('go_top_button', ['Y', 'N'])->default("N");
            $table->enum('posts_page', ['Y', 'N'])->default("N");
            $table->enum('email_form', ['Y', 'N'])->default("N");
            $table->string('google_map_key')->nullable();
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
        Schema::dropIfExists('website_settings');
    }
}
