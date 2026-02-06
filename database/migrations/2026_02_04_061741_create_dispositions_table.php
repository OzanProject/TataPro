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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_mail_id')->constrained('incoming_mails')->onDelete('cascade');
            $table->foreignId('from_user_id')->constrained('users'); // Usually Kepsek
            $table->foreignId('to_user_id')->constrained('users'); // Guru/Staff
            $table->text('instruction'); // Isi disposisi
            $table->text('note')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};
