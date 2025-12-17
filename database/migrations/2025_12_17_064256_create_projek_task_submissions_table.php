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
        Schema::create('projek_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('projektask')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('projekmember')->onDelete('cascade');
            $table->text('url');
            $table->enum('status',['submitted','approved','revisi'])->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projek_task_submissions');
    }
};
