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
        Schema::create('old_table', function (Blueprint $table) {
            $table->id();
            $table->string("roll_no");
            $table->string("emis_no");
            $table->string("student_name");
            $table->string("subject_name");
            $table->string("grade_name");
            $table->string("term_name");
            $table->string("term_marks");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_table');
    }
};
