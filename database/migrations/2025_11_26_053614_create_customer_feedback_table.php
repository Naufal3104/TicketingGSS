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
        Schema::create('customer_feedback', function (Blueprint $table) {
            $table->id('feedback_id'); // BigInt PK
            
            // FK to visit_tickets
            $table->string('visit_ticket_id', 20);
            $table->foreign('visit_ticket_id')->references('visit_ticket_id')->on('visit_tickets')->onDelete('cascade');

            $table->tinyInteger('rating_ts')->nullable(); // 1-5
            $table->tinyInteger('rating_cs')->nullable(); // 1-5
            $table->tinyInteger('rating_sales')->nullable(); // 1-5
            $table->text('review_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_feedback');
    }
};
