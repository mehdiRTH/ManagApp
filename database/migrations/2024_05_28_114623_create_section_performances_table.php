<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('section_performances', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('target_label');
            $table->double('target');
            $table->double('target_achieved');
            $table->date('date');
            $table->foreignUuid('section_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_performances');
    }
};
