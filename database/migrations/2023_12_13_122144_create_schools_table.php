<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Grade;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->unsignedBigInteger('head_of_school_id');
            $table->integer('theory_weightage');
            $table->integer('cas_weightage');
            $table->timestamps();

            // Foreign keys
            $table->foreign('head_of_school_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
