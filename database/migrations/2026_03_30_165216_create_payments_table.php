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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('pidx');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->foreignId('product_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method');
            $table->json('khalti_response')->nullable();
            $table->string('khalti_verification')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index('pidx');
            $table->index('transaction_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};