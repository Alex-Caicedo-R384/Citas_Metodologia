<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }

    public function down()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->string('profile_picture')->nullable();
        });
    }
};
