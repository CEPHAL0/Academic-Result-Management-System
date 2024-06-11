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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("subject_code");
            $table->unsignedBigInteger("department_id");
            $table->enum("type", ["MAIN", "ECA", "CREDIT"]);
            $table->unsignedBigInteger("grade_id");
            $table->float("credit_hr");
            $table->timestamps();


            // Foreign keys
            $table->foreign("department_id")->references("id")->on("departments")->onDelete("restrict")->onUpdate("cascade");
            $table->foreign("grade_id")->references("id")->on("grades")->onDelete("restrict")->onUpdate("cascade");
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
