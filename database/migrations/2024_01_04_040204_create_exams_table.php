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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("term_id");
            $table->unsignedBigInteger("subject_teacher_id");
            $table->integer("mark");

            $table->timestamps();

            // Foreign key
            $table->foreign("student_id")->references("id")->on("students")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign('subject_teacher_id')->references('id')->on('subject_teachers')->onDelete('restrict')->onUpdate("cascade");
            $table->foreign("term_id")->references("id")->on("terms")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
