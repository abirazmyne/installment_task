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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 15);
            $table->string('address'); // Changed from decimal to string
            $table->decimal('installment_amount', 10, 2)->default(0); // Ensure precision and scale
            $table->decimal('installment_amount_stand_current', 10, 2)->default(0); // Ensure precision and scale
            $table->decimal('paid_amount', 10, 2)->default(0); // Ensure precision and scale
            $table->decimal('penalty_amount', 10, 2)->default(0); // Ensure precision and scale
            $table->decimal('payment_pending_amount', 10, 2)->default(0); // Ensure precision and scale
            $table->boolean('paid')->default(false);
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
