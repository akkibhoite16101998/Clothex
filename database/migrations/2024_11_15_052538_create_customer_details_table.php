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
        Schema::create('customer_details', function (Blueprint $table) {
            
            $table->id();  // Primary key 'id' column
            $table->string('name');  // 'name' column
            $table->string('mobile');  // 'mobile' column, assuming it's stored as a string
            $table->date('bill_date');  // 'bill_date' column, stored as a date
            $table->timestamps();  // Adds 'created_at' and 'updated_at' columns

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_details');
    }
};
