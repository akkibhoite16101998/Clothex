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
        Schema::create('payment_details', function (Blueprint $table) {

            $table->id();  // Primary key 'id' column
            $table->string('payment_mode');  // 'payment_mode' column (e.g., 'cash', 'online')
            $table->decimal('disc_percentage', 5, 2)->default(0);  // 'disc_percentage' column
            $table->decimal('disc_amt', 10, 2)->default(0);  // 'disc_amt' column
            $table->decimal('grand_total', 10, 2);  // 'grand_total' column
            $table->decimal('total_paid_amt', 10, 2);  // 'total_paid_amt' column

            // Foreign key referencing 'c_id' on 'customer_details' table
            $table->unsignedBigInteger('c_id');  // 'c_id' column
            $table->foreign('c_id')->references('id')->on('customer_details')->onDelete('cascade');

            $table->timestamps();  // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
