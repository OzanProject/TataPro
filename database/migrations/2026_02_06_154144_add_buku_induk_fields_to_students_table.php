<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Identity
            $table->string('nisn')->nullable()->after('nis');
            $table->string('place_of_birth')->nullable()->after('name');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->enum('gender', ['L', 'P'])->nullable()->after('date_of_birth');
            $table->string('religion')->nullable()->after('gender');

            // Family
            $table->string('father_name')->nullable()->after('address');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('father_job')->nullable()->after('mother_name');
            $table->string('mother_job')->nullable()->after('father_job');
            $table->string('parent_phone')->nullable()->after('mother_job');
            $table->text('parent_address')->nullable()->after('parent_phone');

            // History
            $table->string('previous_school')->nullable()->after('parent_address');
            $table->string('accepted_grade')->nullable()->after('previous_school');
            $table->date('accepted_date')->nullable()->after('accepted_grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nisn',
                'place_of_birth',
                'date_of_birth',
                'gender',
                'religion',
                'father_name',
                'mother_name',
                'father_job',
                'mother_job',
                'parent_phone',
                'parent_address',
                'previous_school',
                'accepted_grade',
                'accepted_date'
            ]);
        });
    }
};
