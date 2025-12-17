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
        Schema::create('projekmember', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projek_id')->constrained('projek')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', [
                'leader',
                'uiux',
                'frontend',
                'backend',
                'fullstack'
            ])->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projekmember');
    }
};
