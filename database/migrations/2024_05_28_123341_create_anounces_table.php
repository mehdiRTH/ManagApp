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
        Schema::create('anounces', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('label');
            $table->longText('message');
            $table->foreignUuid('to')->nullable();
            $table->enum('type',array('Section','All','Direct'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anounces');
    }
};
