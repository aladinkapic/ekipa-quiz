<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuizSetsQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz__sets_questions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('set_id');
            $table->foreign('set_id')
                ->references('id')
                ->on('quiz__sets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('question', 300);
            $table->string('answer')->nullable();
            $table->integer('correct')->default(0);

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
        Schema::dropIfExists('quiz__sets_questions');
    }
}
