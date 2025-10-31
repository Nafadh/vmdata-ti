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
        Schema::create('vms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nama VM
            $table->unsignedBigInteger('category_id');   // relasi ke categories
            $table->integer('storage');              // storage dalam GB
            $table->integer('backup_disk')->nullable(); // backup disk opsional
            $table->text('description')->nullable(); // deskripsi VM
            $table->enum('status', ['available', 'rented', 'maintenance', 'offline'])->default('available');

            //relasi ke category
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // relasi ke user (siapa yang punya VM ini)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // opsional: relasi ke tabel v_m_specifications (kalau mau link spesifikasi default)
            $table->foreignId('specification_id')->nullable()->constrained('v_m_specifications')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vms');
    }
};
