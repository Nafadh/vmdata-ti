<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddExpiredToVmRentalsEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Explicitly alter the enum to include 'expired'.
        // Adjust the list to match the current allowed values in your schema.
        DB::statement("ALTER TABLE `vm_rentals` MODIFY `status` ENUM('active','completed','cancelled','pending','expired') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Intentionally left empty to avoid data loss on rollback.
    }
}
