<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_type_id')->nullable()->constrained('work_types');
            $table->string('slug')->unique();
            $table->integer('year')->nullable();
            $table->date('date')->nullable();
            $table->integer('end_year')->nullable();
            $table->integer('end_date')->nullable();
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->boolean('contains_episodes')->default(false);
            $table->boolean('is_description_ready')->default(false);
            $table->boolean('is_accessible')->default(true);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_published')->default(false);
            $table->json('utils')->default('{}');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE works ADD CONSTRAINT chk_date CHECK (YEAR(`date`) = year or `date` is null)');
        DB::statement('ALTER TABLE works ADD CONSTRAINT chk_end_date CHECK (YEAR(end_date) = end_year or end_date is null)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
