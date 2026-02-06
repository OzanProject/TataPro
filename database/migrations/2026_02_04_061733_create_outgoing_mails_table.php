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
        Schema::create('outgoing_mails', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_number')->unique()->nullable(); // No. Agenda Keluar
            $table->string('mail_number')->unique()->nullable(); // Generated System (e.g., 421/105/SMK/2026)
            $table->string('recipient_destination'); // Tujuan Surat
            $table->string('subject');
            $table->date('mail_date');
            $table->foreignId('category_id')->constrained('mail_categories')->onDelete('cascade');
            $table->text('content')->nullable(); // Rich Text content surat
            $table->string('file_path')->nullable(); // Hasil generate PDF
            $table->enum('status', ['draft', 'pending_approval', 'signed', 'sent'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Kepala Sekolah
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_mails');
    }
};
