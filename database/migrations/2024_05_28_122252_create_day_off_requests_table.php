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
        Schema::create('off_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('label');
            $table->longText('description');
            $table->string('duration');
            $table->string('type');
            $table->longtext('justification');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignUuid('user_id');
            $table->enum('status',array('Pending','Accepted','Refused'));
            $table->string('status_answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('off_requests');
    }
};
