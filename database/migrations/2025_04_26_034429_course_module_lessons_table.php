<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_module_lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(DB::raw('(gen_random_uuid())'));
            $table->foreignId('course_module_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->integer('duration');
            $table->string('video_url');
            $table->text('notes')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_module_lessons');
    }
};
