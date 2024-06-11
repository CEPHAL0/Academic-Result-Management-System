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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("grade_id");
            $table->unsignedBigInteger("class_teacher_id");
            $table->timestamps();

            // Foreign Keys
            $table->foreign("grade_id")->references("id")->on("grades")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("class_teacher_id")->references("id")->on("users")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
