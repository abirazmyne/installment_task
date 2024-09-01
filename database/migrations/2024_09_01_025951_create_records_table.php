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
            $table->foreignId('member_id')->constrained()->onDelete('cascade'); // This line ensures member_id is a foreign key and required
            $table->string('name');
            $table->string('email');
            $table->string('phone', 15);
            $table->string('address');
            $table->decimal('installment_amount', 8, 2);
            $table->decimal('amount', 10, 2); // The original installment amount
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
        Schema::dropIfExists('records');
    }
};
