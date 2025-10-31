<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'expired' to vm_rentals.status enum
        // Use raw SQL for MySQL to alter enum safely
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            // vm_rentals
            try {
                DB::statement("ALTER TABLE `vm_rentals` MODIFY `status` ENUM('active','completed','cancelled','pending','expired') NOT NULL DEFAULT 'pending'");
            } catch (\Exception $e) {
                // ignore if already modified or other DBs
                logger()->warning('Failed to alter vm_rentals.status to add expired: '.$e->getMessage());
            }

            // rentals table: convert localized values to english-like values and add expired if needed
            try {
                // If rentals.status uses different strings (e.g., 'Aktif'), we do a safe update to normalize common values
                // Ensure column is string (it is string in migration), and update rows whose end_date < now() to 'expired'
                DB::statement("UPDATE `rentals` SET `status` = 'expired' WHERE `end_date` < CURDATE() AND `status` NOT IN ('expired')");
            } catch (\Exception $e) {
                logger()->warning('Failed to update rentals to expired where needed: '.$e->getMessage());
            }
        } else {
            // For other DBs, no-op; the command handles expiry idempotently
            logger()->info('Skipping enum migration for non-mysql driver: '.$driver);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't attempt to remove the 'expired' value to avoid data loss
    }
};
