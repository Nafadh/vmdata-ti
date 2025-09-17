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
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('hostname')->unique();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('v_m_specification_id')->constrained('v_m_specifications')->cascadeOnDelete();
            $table->enum('os', ['ubuntu', 'centos', 'windows', 'debian']);
            $table->string('ip_address')->nullable();
            $table->enum('status', ['available', 'rented', 'maintenance', 'offline']);
            $table->text('description')->nullable();
            $table->json('ports')->nullable(); // Open ports
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
