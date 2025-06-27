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
            $table->foreignId('user_id')->constrained('users');

            $table->string('topic');
            $table->integer('step')->default(1);
            $table->integer('ex')->default(0);
            $table->integer('freetime');
            $table->date('date_start');
            $table->enum('status',[0,1,2]);
            $table->enum('level',['ignorant','knowing','experienced'])->default('ignorant');
            $table->string('logo')->nullable();
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
