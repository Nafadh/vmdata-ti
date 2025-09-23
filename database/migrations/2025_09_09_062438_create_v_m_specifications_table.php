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
        Schema::create('v_m_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // nama VM
            $table->integer('ram');            // RAM dalam GB
            $table->integer('storage');        // storage dalam GB
            $table->integer('backup_disk')->nullable(); // backup disk opsional
            $table->text('description')->nullable();    // deskripsi
            $table->enum('status', ['available', 'rented', 'maintenance', 'offline'])->default('available'); // status VM
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_m_specifications');
    }
};
