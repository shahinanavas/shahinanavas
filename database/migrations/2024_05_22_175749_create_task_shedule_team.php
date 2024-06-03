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
        Schema::create('task_shedule_team', function (Blueprint $table) {
            $table->id();
            $table->string('name_project');
            $table->string('team_name');
            $table->string('assigned_to');
            $table->string('task_name');
            $table->string('task_description');
            $table->string('allocation_date');
            $table->string('deadline_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_shedule_team');
    }
};
