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
        Schema::create('old_cas_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("old_table_id");
            $table->string("cas_type");
            $table->string("cas_marks");
            $table->string("assignment_name");
            $table->string("subject_name");
            $table->timestamps();

            $table->foreign("old_table_id")->references("id")->on("old_table");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_cas_marks');
    }
};
