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
        Schema::create('cas_types', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("school_id");
            $table->integer("full_marks");
            $table->integer("weightage");
            $table->timestamps();


            // Foreign Keys
            $table->foreign("school_id")->references("id")->on("schools")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cas_types');
    }
};
