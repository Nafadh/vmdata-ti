<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            // Tambah kolom server_id jika belum ada
            if (!Schema::hasColumn('vms', 'server_id')) {
                $table->unsignedBigInteger('server_id')->nullable()->after('id');
                $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
            $table->dropColumn('server_id');
        });
    }
};