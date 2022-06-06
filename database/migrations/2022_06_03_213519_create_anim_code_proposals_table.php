<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimCodeProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anim_code_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_id');
            $table->string('combination', 5);
            $table->string('player', 30);
            $table->tinyInteger('points');

            $table->foreign('code_id')->references('id')->on('anim_code_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anim_code_proposals', function (Blueprint $table) {
            $table->dropForeign(['code_id']);
        });
        Schema::dropIfExists('anim_code_proposals');
    }
}
