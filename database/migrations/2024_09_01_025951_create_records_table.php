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
            $table->string('address');
            $table->decimal('installment_amount', 8, 2);
            $table->decimal('installment_amount_stand_current', 8, 2)->nullable(); // Made nullable
            $table->string('paid_amount')->nullable();
            $table->decimal('penalty_amount', 10, 2)->default(0);
            $table->decimal('payment_pending_amount', 10, 2)->default(0);
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
