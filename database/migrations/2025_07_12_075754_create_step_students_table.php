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
        Schema::create('step_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('step_id')->constrained('steps')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('ex')->default(0);
            $table->enum('status',['0','1','2'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('step_students');
    }
};
