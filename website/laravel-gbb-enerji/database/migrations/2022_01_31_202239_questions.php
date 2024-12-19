<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizes_id')->constrained()->delete('cascade');
            $table->longText('question');
            $table->longText('subject');
            $table->longText('level');
            $table->longText('line');
            $table->longText('A');
            $table->longText('B');
            $table->longText('C')->nullable();
            $table->longText('D')->nullable();
            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);
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
        Schema::dropIfExists('questions');
    }
}
