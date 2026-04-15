<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, clean up any invalid inventory records
        DB::table('inventories')->delete();
        
        Schema::table('inventories', function (Blueprint $table) {
            // Check if product_id column exists and is string, then modify it
            if (Schema::hasColumn('inventories', 'product_id')) {
                // Drop the existing string product_id column
                $table->dropColumn('product_id');
            }
            
            // Add proper foreign key column
            $table->unsignedBigInteger('product_id')->after('id');
            $table->foreign('product_id')->references('p_id')->on('products')->onDelete('cascade');
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
            
            // Add back the original string column
            $table->string('product_id')->unique()->after('id');
        });
    }
};
