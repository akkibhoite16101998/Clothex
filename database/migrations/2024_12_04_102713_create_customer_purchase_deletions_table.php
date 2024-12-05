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
        Schema::create('customer_purchase_deletions', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('c_id'); 
            $table->unsignedBigInteger('product_id'); 
            $table->integer('quantity'); 
            $table->decimal('price', 10, 2); 
            $table->decimal('disc_percentage', 5, 2)->nullable(); 
            $table->text('reason')->nullable(); 
            $table->timestamp('delete_date'); 
            $table->unsignedBigInteger('deleted_by'); 
        
            // Foreign key constraints
            $table->foreign('c_id')->references('id')->on('customer_details');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_purchase_deletions');
    }
};
