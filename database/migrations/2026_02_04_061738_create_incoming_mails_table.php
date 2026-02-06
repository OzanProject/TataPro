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
        Schema::create('incoming_mails', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_number')->unique(); // No. Urut Buku Agenda
            $table->string('mail_number'); // Nomor Surat dari Pengirim
            $table->string('sender_origin'); // Asal Surat
            $table->string('subject'); // Perihal
            $table->date('received_date'); // Tanggal Diterima
            $table->date('mail_date'); // Tanggal Surat
            $table->foreignId('category_id')->constrained('mail_categories')->onDelete('cascade');
            $table->string('file_path')->nullable(); // Scan surat
            $table->enum('status', ['received', 'dispositioned', 'processed'])->default('received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_mails');
    }
};
