<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('employee', function (Blueprint $table) {

            $table->id(); 
            $table->string('name');        
            $table->string('employee_address');         
            $table->string('aadhar_no'); 
            $table->string('dob'); 
            $table->string('qualification'); 
            $table->string('phone_no');    
            $table->string('designation'); 
            $table->string('emptype'); 
            $table->string('join_date');     
            $table->string('salary');     
            $table->string('salary_date');
            $table->string('image');  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
