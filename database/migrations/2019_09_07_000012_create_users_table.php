<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('mobile', 15)->unique();
            $table->string('password');
            $table->string('password_txt');
            $table->string('role');
            $table->char('api_token', 60)->unique()->nullable();
            $table->string('last_login')->nullable();
            $table->tinyInteger('active')->nullable()->default(1);
            $table->integer('approved_by')->nullable()->default(1);
            $table->integer('disabled_by')->unsigned()->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
