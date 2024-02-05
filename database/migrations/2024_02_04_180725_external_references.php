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
        Schema::create('external_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_reference_type_id')->constrained('external_reference_types');
            $table->foreignId('work_id')->constrained('works');
            $table->string('url', 512);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_references');
    }
};
