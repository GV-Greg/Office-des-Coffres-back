<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimRewardsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anim_rewards_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grid_id');
            $table->string('name', 50);
            $table->integer('place')->nullable();
            $table->string('player', 40)->nullable();
            $table->boolean('is_taken')->default(0);

            $table->foreign('grid_id')->references('id')->on('anim_rewards_grids')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anim_rewards_lists', function (Blueprint $table) {
            $table->dropForeign(['grid_id']);
        });
        Schema::dropIfExists('anim_rewards_lists');
    }
}
