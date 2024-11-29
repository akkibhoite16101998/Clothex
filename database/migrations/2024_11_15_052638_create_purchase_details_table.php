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
        Schema::create('purchase_details', function (Blueprint $table) {
            
            $table->id();  // Primary key 'id' column
            $table->string('product_name');  // 'product_name' column
            $table->integer('quantity');  // 'quantity' column
            $table->decimal('price', 8, 2);  // 'price' column with precision 8, scale 2
            $table->decimal('total_amt', 10, 2);  // 'total_amt' column with precision 10, scale 2

            // Foreign key referencing 'c_id' on 'customer_details' table
            $table->unsignedBigInteger('c_id');  // 'c_id' column
            $table->foreign('c_id')->references('id')->on('customer_details')->onDelete('cascade'); 

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
