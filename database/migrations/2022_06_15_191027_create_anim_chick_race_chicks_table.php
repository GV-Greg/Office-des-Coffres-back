<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimChickRaceChicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anim_chick_race_chicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chick_race_activity_id');
            $table->string('name_player', 50);
            $table->string('name_chick', 50);
            $table->enum('color', ['gray', 'yellow', 'orange', 'black']);
            $table->tinyInteger('position_x');
            $table->tinyInteger('position_y')->default(0);
            $table->timestamps();

            $table->foreign('chick_race_activity_id')->references('id')->on('anim_chick_race_activity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anim_chick_race_chicks');
    }
}
