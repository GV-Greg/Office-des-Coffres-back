<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimCodeCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anim_code_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_activity_id');
            $table->string('code', 255);
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('code_activity_id')->references('id')->on('anim_code_activity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anim_code_codes', function (Blueprint $table) {
            $table->dropForeign(['code_activity_id']);
        });
        Schema::dropIfExists('anim_code_codes');
    }
}
