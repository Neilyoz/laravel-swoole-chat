<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldHeadPicToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'head_pic')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('head_pic')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'head_pic')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('head_pic');
            });
        }
    }
}
