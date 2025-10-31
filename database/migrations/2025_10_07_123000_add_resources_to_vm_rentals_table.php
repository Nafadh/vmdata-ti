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
        // Add new columns if they don't exist using Schema builder (adding columns does not require doctrine/dbal)
        Schema::table('vm_rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('vm_rentals', 'cpu')) {
                $table->unsignedTinyInteger('cpu')->default(1)->after('vm_id');
            }
            if (!Schema::hasColumn('vm_rentals', 'ram')) {
                $table->integer('ram')->default(1)->after('cpu');
            }
            if (!Schema::hasColumn('vm_rentals', 'storage')) {
                $table->integer('storage')->default(1)->after('ram');
            }
            if (!Schema::hasColumn('vm_rentals', 'backup_disk')) {
                $table->integer('backup_disk')->nullable()->after('storage');
            }
        });

        // Modify total_cost column using raw SQL so we don't need doctrine/dbal for change()
        try {
            // MySQL syntax: MODIFY column to set default 0 and NOT NULL
            DB::statement("ALTER TABLE `vm_rentals` MODIFY `total_cost` DECIMAL(10,2) NOT NULL DEFAULT 0;");
        } catch (\Exception $e) {
            // If the column doesn't exist, add it
            if (!Schema::hasColumn('vm_rentals', 'total_cost')) {
                Schema::table('vm_rentals', function (Blueprint $table) {
                    $table->decimal('total_cost', 10, 2)->default(0)->after('end_time');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vm_rentals', function (Blueprint $table) {
            if (Schema::hasColumn('vm_rentals', 'cpu')) {
                $table->dropColumn('cpu');
            }
            if (Schema::hasColumn('vm_rentals', 'ram')) {
                $table->dropColumn('ram');
            }
            if (Schema::hasColumn('vm_rentals', 'storage')) {
                $table->dropColumn('storage');
            }
            if (Schema::hasColumn('vm_rentals', 'backup_disk')) {
                $table->dropColumn('backup_disk');
            }
            // rollback total_cost change (set to nullable without default)
            if (Schema::hasColumn('vm_rentals', 'total_cost')) {
                $table->decimal('total_cost', 10, 2)->nullable()->change();
            }
        });
    }
};
