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
        Schema::create('visit_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 20); // TS
            $table->unsignedBigInteger('visit_assignment_id')->nullable();

            // Data Absensi (Realita Lapangan)
            $table->dateTime('check_in_time');
            $table->string('check_in_location')->nullable(); // Koordinat/Alamat GPS
            $table->text('check_in_photo')->nullable(); // Foto selfie/lokasi saat datang

            $table->dateTime('check_out_time')->nullable();
            $table->string('check_out_location')->nullable();
            $table->text('check_out_photo')->nullable();
            $table->text('work_report')->nullable();
            $table->timestamps();

            $table->foreign('visit_assignment_id')->references('assignment_id')->on('visit_assignments')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_attendances');
    }
};
