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
        Schema::create('vm_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('vm_id')->constrained();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->decimal('total_cost', 10, 2);
            $table->enum('status', ['active', 'completed', 'cancelled', 'pending']);
            $table->text('purpose')->nullable(); // Tujuan penggunaan
            $table->json('access_credentials')->nullable(); // SSH keys, passwords, etc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vm_rentals');
    }
};
