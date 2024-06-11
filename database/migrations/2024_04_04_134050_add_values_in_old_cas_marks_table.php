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
        Schema::table('old_cas_marks', function (Blueprint $table) {
            $table->string('roll_number');
            $table->string('student_name');
            $table->string('term_name');
            $table->string('grade_name');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('old_cas_marks', function (Blueprint $table) {
            //
        });
    }
};
