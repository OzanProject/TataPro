<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('document_templates', function (Blueprint $table) {
      $table->string('type')->default('student')->after('name'); // student, teacher, general
    });

    // Update existing to student default
    DB::table('document_templates')->update(['type' => 'student']);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('document_templates', function (Blueprint $table) {
      $table->dropColumn('type');
    });
  }
};
