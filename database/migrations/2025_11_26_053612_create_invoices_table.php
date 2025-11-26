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
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('invoice_id', 20)->primary(); // PK
            
            // FK to visit_tickets
            $table->string('visit_ticket_id', 20);
            $table->foreign('visit_ticket_id')->references('visit_ticket_id')->on('visit_tickets')->onDelete('cascade');
            
            // FK to users (Sales)
            $table->string('sales_id', 20);
            $table->foreign('sales_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->decimal('amount_base', 15, 2)->default(0);
            $table->decimal('amount_discount', 15, 2)->default(0);
            $table->decimal('amount_final', 15, 2)->default(0);
            $table->enum('status', ['DRAFT', 'SENT', 'PAID', 'CANCELLED'])->default('DRAFT');
            $table->text('payment_proof_url')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
