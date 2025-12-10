<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'trang_thai_duyet')) {
                $table->enum('trang_thai_duyet', ['pending','approved','hidden'])->default('pending')->after('trang_thai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'trang_thai_duyet')) {
                $table->dropColumn('trang_thai_duyet');
            }
        });
    }
};
