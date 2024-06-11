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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->text("description")->nullable();
            $table->date("date_assigned");
            $table->unsignedBigInteger("subject_teacher_id");
            $table->integer("full_marks");
            $table->unsignedBigInteger("cas_type_id");
            $table->unsignedBigInteger("term_id");
            $table->timestamps();

            // Foreign Key
            $table->foreign("cas_type_id")->references("id")->on("cas_types")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("subject_teacher_id")->references("id")->on("subject_teachers")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("term_id")->references("id")->on("terms")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
