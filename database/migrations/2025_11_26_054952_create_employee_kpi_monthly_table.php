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
        Schema::create('employee_kpi_monthly', function (Blueprint $table) {
            $table->id('kpi_id'); // BigInt PK
            
            // FK to users (Employee)
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->string('period_month', 7); // YYYY-MM
            $table->integer('total_tasks')->default(0);
            $table->decimal('avg_rating', 3, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_kpi_monthly');
    }
};
