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
        Schema::create('counselor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained()->cascadeOnDelete();

            $table->string('day_of_week');
            $table->string('timeslot');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_availabilities');
    }
};
