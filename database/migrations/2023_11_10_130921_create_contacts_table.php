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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_mobile')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_image')->nullable();
            $table->text('message')->nullable();
            $table->unsignedInteger('landing_id')->nullable();
            $table->unsignedTinyInteger('subject')->nullable();
            $table->unsignedTinyInteger('status')->nullable();
            $table->timestamps();

            $table->foreign('landing_id')->references('id')->on('landings')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
