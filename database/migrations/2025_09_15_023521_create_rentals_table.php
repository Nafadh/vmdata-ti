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
        Schema::create('rentals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('vm_id')->constrained()->onDelete('cascade'); // asumsi ada tabel vms
    $table->date('start_date');
    $table->date('end_date');
    $table->string('status')->default('Aktif'); // Aktif, Selesai, Pending
    $table->foreignId('admin_id')->constrained('users'); // penanggung jawab
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
