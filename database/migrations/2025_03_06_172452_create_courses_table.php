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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('topic');
            $table->enum('type',['public','private'])->default("private");
            $table->integer('step')->default(0);
            $table->integer('ex')->default(0);
            $table->integer('freetime');
            $table->date('date_start');
            $table->enum('status',[0,1,2]);
            $table->enum('level',['beginner','intermediate','advanced'])->default('beginner');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
