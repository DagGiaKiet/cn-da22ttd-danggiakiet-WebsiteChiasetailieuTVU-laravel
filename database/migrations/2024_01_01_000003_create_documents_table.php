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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('ten_tai_lieu');
            $table->text('mo_ta')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->decimal('gia', 10, 2)->default(0);
            $table->enum('loai', ['ban', 'cho'])->default('cho');
            $table->foreignId('khoa_id')->constrained('khoas')->onDelete('cascade');
            $table->foreignId('nganh_id')->constrained('nganhs')->onDelete('cascade');
            $table->foreignId('mon_id')->constrained('mons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('trang_thai', ['available', 'sold'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
