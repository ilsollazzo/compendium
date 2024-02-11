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
        Schema::create('work_episode_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_episode_id')->constrained('work_episodes');
            $table->foreignId('language_id')->constrained('languages');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_episode_titles');
    }
};
