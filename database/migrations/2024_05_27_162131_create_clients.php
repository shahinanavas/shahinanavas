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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->text('client_address');
            $table->string('client_phone_no')->nullable();
            $table->string('project_name');
            $table->string('project_type');
            $table->string('project_type_detail')->nullable();
            $table->string('client_project_status');
            $table->string('quotation_sent')->nullable();
            $table->string('quotation_file')->nullable();
            $table->string('quotation_status')->nullable();
            $table->double('total_amount');
            $table->double('amount_paid');
            $table->double('balance');
            $table->string('payment_method');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
