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
        Schema::table('inventories', function (Blueprint $table) {
            // Drop existing product_id column if it exists and recreate it as proper foreign key
            $table->dropColumn('product_id');
        });
        
        Schema::table('inventories', function (Blueprint $table) {
            // Add proper foreign key to products table
            $table->unsignedBigInteger('product_id')->after('id');
            $table->foreign('product_id')->references('p_id')->on('products')->onDelete('cascade');
            
            // Drop redundant columns since we'll get them from product relationship
            $table->dropColumn(['product_name', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            
            // Add back the dropped columns
            $table->string('product_name')->after('id');
            $table->string('category')->after('product_name');
        });
    }
};
