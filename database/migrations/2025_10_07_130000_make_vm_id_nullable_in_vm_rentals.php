<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to avoid doctrine/dbal requirement for change()
        try {
            // Drop foreign key if exists (MySQL)
            DB::statement("ALTER TABLE `vm_rentals` DROP FOREIGN KEY IF EXISTS `vm_rentals_vm_id_foreign`;");
        } catch (\Exception $e) {
            // ignore if drop FK not supported that way in this DB
        }

        // Make vm_id nullable via raw SQL (MySQL syntax)
        try {
            DB::statement("ALTER TABLE `vm_rentals` MODIFY `vm_id` BIGINT UNSIGNED NULL;");
        } catch (\Exception $e) {
            // If MODIFY fails, fallback to schema builder attempt
            Schema::table('vm_rentals', function (Blueprint $table) {
                if (!Schema::hasColumn('vm_rentals', 'vm_id')) return;
                // fallback: attempt to make column nullable (may still require dbal)
                $table->unsignedBigInteger('vm_id')->nullable()->change();
            });
        }

        // Recreate foreign key with ON DELETE SET NULL
        try {
            DB::statement("ALTER TABLE `vm_rentals` ADD CONSTRAINT `vm_rentals_vm_id_foreign` FOREIGN KEY (`vm_id`) REFERENCES `vms`(`id`) ON DELETE SET NULL;");
        } catch (\Exception $e) {
            // ignore if FK creation fails (it may already exist)
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vm_rentals', function (Blueprint $table) {
            // drop FK
            $table->dropForeign(['vm_id']);
            // make column not nullable
            $table->unsignedBigInteger('vm_id')->nullable(false)->change();
            // re-add FK default behavior (restrict)
            $table->foreign('vm_id')->references('id')->on('vms');
        });
    }
};
