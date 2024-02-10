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
        Schema::create('work_list_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_list_id')->constrained('work_lists');
            $table->foreignId('language_id')->constrained('languages');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_list_names');
    }
};
