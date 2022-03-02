<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuizSets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz__sets', function (Blueprint $table) {
            $table->id();

            $table->integer('quiz_id');
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quiz')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('player_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz__sets');
    }
}
