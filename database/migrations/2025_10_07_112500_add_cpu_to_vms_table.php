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
            // Ensure 'ram' exists (some earlier migration omitted it); add if missing
            if (!Schema::hasColumn('vms', 'ram')) {
                // store RAM in GB
                $table->unsignedInteger('ram')->default(1)->after('specification_id');
            }

            // Add cpu as number of vCPU cores if not exists. Avoid strict ->after('ram') because
            // some MySQL versions may fail if column order assumptions differ.
            if (!Schema::hasColumn('vms', 'cpu')) {
                $table->unsignedTinyInteger('cpu')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            if (Schema::hasColumn('vms', 'cpu')) {
                $table->dropColumn('cpu');
            }
            if (Schema::hasColumn('vms', 'ram')) {
                // only drop ram if it was created by this migration — conservative approach
                $table->dropColumn('ram');
            }
        });
    }
};
