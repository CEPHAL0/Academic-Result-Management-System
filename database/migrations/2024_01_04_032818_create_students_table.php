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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('roll_number')->unique();
            $table->unsignedBigInteger('section_id');
            $table->date('date_of_birth');
            $table->string('father_name');
            $table->string('father_contact');
            $table->string('mother_name');
            $table->string('mother_contact');
            $table->string('guardian_name');
            $table->string('guardian_contact');
            $table->string('email')->unique();
            $table->string("fathers_profession");
            $table->string("mothers_profession");
            $table->string("guardians_profession");
            $table->string("emis_no")->unique();
            $table->string("reg_no")->nullable();
            $table->string("image")->nullable();
            $table->enum('status', ['ACTIVE', 'DROPPED_OUT'])->default('ACTIVE');
            $table->timestamps();

            // Foreign Key
            $table->foreign("section_id")->references("id")->on("sections")->onDelete("restrict")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
