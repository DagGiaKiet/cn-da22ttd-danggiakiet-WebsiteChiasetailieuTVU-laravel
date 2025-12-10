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
        Schema::create('khoas', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khoa');
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });

        Schema::create('nganhs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nganh');
            $table->foreignId('khoa_id')->constrained('khoas')->onDelete('cascade');
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });

        Schema::create('mons', function (Blueprint $table) {
            $table->id();
            $table->string('ten_mon');
            $table->foreignId('nganh_id')->constrained('nganhs')->onDelete('cascade');
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mons');
        Schema::dropIfExists('nganhs');
        Schema::dropIfExists('khoas');
    }
};
