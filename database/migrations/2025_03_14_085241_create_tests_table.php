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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('step_id')->constrained('steps');
            $table->foreignId('skill_id')->constrained('skills');
            $table->string('text');
            $table->enum('type_test',["one_correct","list_correct","question_answer","matching","true_false"]);
            $table->text('variants')->nullable();
            $table->boolean('view')->default(0);
            $table->text('correct')->nullable();
            $table->integer('score')->default(0);
            $table->text('list1')->nullable();
            $table->text('list2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
