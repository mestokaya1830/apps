<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JoinedQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joined_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joiner_id')->constrained()->delete('cascade');
            $table->bigInteger('quizes_id');
            $table->longText('question');
            $table->longText('subject');
            $table->longText('level');
            $table->longText('line');
            $table->longText('A');
            $table->longText('B');
            $table->longText('C')->nullable();
            $table->longText('D')->nullable();
            $table->string('correct_answer');
            $table->string('answers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joined_quizzes');
    }
}
