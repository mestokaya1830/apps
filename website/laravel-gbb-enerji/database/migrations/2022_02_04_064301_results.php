<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Results extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joiner_id')->constrained()->delete('cascade');
            $table->foreignId('quizes_id')->constrained()->delete('cascade');
            $table->integer('correct_count');
            $table->integer('wrong_count');
            $table->integer('score');
            $table->integer('diff')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}
