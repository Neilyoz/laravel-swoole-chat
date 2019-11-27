<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('friends')) {
            Schema::create('friends', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('owner_id');
                $table->bigInteger('relation_id');
                $table->timestamps();
                $table->softDeletes();
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
        if (Schema::hasTable('friends')) {
            Schema::dropIfExists('friends');
        }
    }
}
