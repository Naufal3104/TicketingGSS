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
        Schema::create('visit_documents', function (Blueprint $table) {
            $table->id('document_id'); // BigInt PK
            
            // FK to visit_tickets
            $table->string('visit_ticket_id', 20);
            $table->foreign('visit_ticket_id')->references('visit_ticket_id')->on('visit_tickets')->onDelete('cascade');
            $table->foreign('uploader_id')->references('user_id')->on('users')->onDelete('cascade');

            // FK to users (Uploader)
            $table->string('uploader_id', 20);
            // $table->foreign('uploader_id')->references('user_id')->on('users');

            $table->enum('document_type', ['SURAT_TUGAS', 'SURAT_JALAN', 'BAST_SIGNED', 'EVIDENCE_PHOTO', 'OTHER']);
            $table->text('file_url');
            $table->string('file_name', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_documents');
    }
};
