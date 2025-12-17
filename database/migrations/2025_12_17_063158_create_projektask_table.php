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
        Schema::create('projektask', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('projek_id')->constrained('projek')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('projekmember')->onDelete('cascade');
            $table->foreignId('createBy')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projektask');
    }
};
