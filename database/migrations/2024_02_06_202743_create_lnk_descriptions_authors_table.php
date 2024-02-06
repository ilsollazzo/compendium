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
        Schema::create('lnk_descriptions_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_description_id')->constrained('work_descriptions');
            $table->foreignId('work_description_author_id')->constrained('work_description_authors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lnk_descriptions_authors');
    }
};
