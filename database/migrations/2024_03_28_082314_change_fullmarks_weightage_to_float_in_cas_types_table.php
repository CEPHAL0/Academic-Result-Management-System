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
        Schema::table('cas_types', function (Blueprint $table) {
            //
            $table->float("full_marks")->change();
            $table->float("weightage")->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cas_types', function (Blueprint $table) {
            //
        });
    }
};
