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
        Schema::create('subject_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("teacher_id");
            $table->unsignedBigInteger("section_id");
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign("subject_id")->references("id")->on("subjects")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("teacher_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("section_id")->references("id")->on("sections")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_teachers');
    }
};
