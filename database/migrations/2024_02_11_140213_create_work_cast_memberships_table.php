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
        Schema::create('work_cast_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('works');
            $table->foreignId('cast_member_id')->constrained('cast_members');
            $table->foreignId('cast_role_id')->constrained('cast_roles');
            $table->foreignId('work_episode_id')->nullable()->constrained('work_episodes');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_cast_memberships');
    }
};
