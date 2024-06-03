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
        Schema::create('task_shedule', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('assign_to');
            $table->string('taskname');
            $table->string('taskdescription');
            $table->string('allocationdate');
            $table->string('deadlinedate');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_shedule');
    }
};
