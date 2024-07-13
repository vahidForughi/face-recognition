<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->text('notice')->nullable();
            $table->text('results')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exam_options', function (Blueprint $table) {
            $table->increments('id');
            $table->json('options');
            $table->string('scores')->nullable();
            $table->string('media')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exam_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id')->nullable();
            $table->string('title');
            $table->string('media')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedInteger('exam_option_id')->nullable();
            $table->text('options')->nullable();
            $table->text('scores')->nullable();
            $table->string('rules')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('exam_option_id')->references('id')->on('exam_options')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('exam_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('fullname')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedTinyInteger('gender')->length(1)->nullable();
            $table->string('city')->nullable();
            $table->json('responses');
            $table->integer('score')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
        Schema::dropIfExists('exam_options');
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exam_participants');
    }
};
