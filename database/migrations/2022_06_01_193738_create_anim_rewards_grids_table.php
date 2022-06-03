<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimRewardsGridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anim_rewards_grids', function (Blueprint $table) {
            $table->id();
            $table->string('name', 190);
            $table->unsignedBigInteger('creator_id');
            $table->integer('width');
            $table->integer('height');
            $table->enum('status', ['new', 'incomplete', 'filled', 'drawed','confirmed', 'closed']);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anim_rewards_grids');
    }
}
