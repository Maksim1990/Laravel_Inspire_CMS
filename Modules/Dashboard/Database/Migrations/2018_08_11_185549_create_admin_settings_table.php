<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('app_version')->nullable();
            $table->string('app_name')->nullable();
            $table->enum('app_status', ['Y', 'N'])->default("Y");
            $table->enum('use_admin_ftp_credentials', ['Y', 'N'])->default("N");
            $table->enum('use_remote_server', ['Y', 'N'])->default("N");
            $table->text('remote_server')->nullable();
            $table->enum('use_elasticsearch', ['Y', 'N'])->default("N");
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
        Schema::dropIfExists('admin_settings');
    }
}
