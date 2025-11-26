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
        Schema::create('visit_assignments', function (Blueprint $table) {
            $table->id('assignment_id'); // BigInt PK
            
            // FK to visit_tickets
            $table->string('visit_ticket_id', 20);
            $table->foreign('visit_ticket_id')->references('visit_ticket_id')->on('visit_tickets')->onDelete('cascade');
            $table->foreign('ts_id')->references('user_id')->on('users')->onDelete('cascade');

            // FK to users (TS) - assuming user_id is the key to link
            $table->string('ts_id', 20);
            // $table->foreign('ts_id')->references('user_id')->on('users'); // Uncomment if user_id is unique and indexed

            $table->timestamp('assigned_at')->useCurrent();
            $table->string('google_event_id', 255)->nullable();
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->string('check_in_location', 100)->nullable();
            $table->text('work_report')->nullable();
            $table->enum('status', ['PENDING', 'ON_SITE', 'DONE'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_assignments');
    }
};
