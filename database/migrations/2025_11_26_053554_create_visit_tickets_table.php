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
        Schema::create('visit_tickets', function (Blueprint $table) {
            // ERD: visit_ticket_id varchar(20) PK
            $table->string('visit_ticket_id', 20)->primary();
            
            // Foreign Key to customers.customer_id
            $table->string('customer_id', 20);
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');

            $table->string('created_by', 20)->nullable(); // Assuming this links to user_id or just a name
            $table->string('issue_category', 50)->nullable();
            $table->text('issue_description')->nullable();
            $table->text('visit_address')->nullable();
            $table->enum('priority_level', ['LOW', 'MEDIUM', 'HIGH', 'URGENT'])->default('LOW');
            $table->tinyInteger('ts_quota_needed')->default(1);
            $table->enum('status', ['UNVERIFIED', 'OPEN', 'BIDDING', 'ASSIGNED', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED', 'ARCHIVED'])->default('UNVERIFIED');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_tickets');
    }
};
