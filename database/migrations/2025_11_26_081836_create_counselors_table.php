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
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();

            // Authentication fields
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Profile fields
            $table->string('name');
            $table->string('profile_image')->nullable();
            $table->string('occupation')->nullable();
            $table->string('specialties')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('languages')->nullable();

            $table->decimal('rating', 3, 2)->default(0);
            $table->text('description')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};
