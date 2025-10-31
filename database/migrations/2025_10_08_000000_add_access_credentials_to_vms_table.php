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
        Schema::table('vms', function (Blueprint $table) {
            $table->string('access_username')->nullable()->after('description');
            // store encrypted password as text
            $table->text('access_password')->nullable()->after('access_username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            $table->dropColumn(['access_username', 'access_password']);
        });
    }
};
