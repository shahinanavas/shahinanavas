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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->dateTime('checkin_time')->nullable();
            $table->dateTime('checkout_time')->nullable();
            $table->string('status')->nullable();
            $table->decimal('salary_reduction', 10, 2)->default(0.00);
            $table->decimal('remaining_salary', 10, 2)->default(0.00);
            $table->decimal('total_salary', 10, 2)->default(0.00);
            $table->decimal('day_salary', 10, 2)->nullable();
            $table->decimal('total_day_salary', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
     
     
    }
};
