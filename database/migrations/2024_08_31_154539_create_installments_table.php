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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 10, 2)->default(0); // The original installment amount
            $table->decimal('payment_pending_old', 10, 2)->default(0); // Pending amount before the current installment
            $table->decimal('payment_pending_increased', 10, 2)->default(0); // Pending amount after applying the increased installment
            $table->decimal('penalty_amount', 10, 2)->default(0); // Any penalty applied
            $table->decimal('payment_pending_amount', 10, 2)->default(0); // The amount still pending
            $table->boolean('paid')->default(false); // Whether the installment is paid

            $table->date('due_date'); // The due date of the installment
            $table->date('payment_date')->nullable(); // The actual payment date if paid
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
