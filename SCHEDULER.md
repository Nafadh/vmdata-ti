# Scheduler setup (Windows Task Scheduler / Linux cron)

This project uses Laravel's scheduler. To run scheduled tasks automatically, the host must call `php artisan schedule:run` on an interval (commonly every 5 minutes).

Included helper
 - `scripts/run-schedule.ps1` — PowerShell script that runs `php artisan schedule:run` from the project root and appends output to `storage/logs/scheduler-YYYYMMDD.log`.

Quick test (PowerShell)

Run the helper manually to test:

```powershell
# from project root
PowerShell -NoProfile -ExecutionPolicy Bypass -File .\scripts\run-schedule.ps1

# Or run the artisan command directly:
php artisan schedule:run
```

Windows Task Scheduler (automatic)

1. Ensure `php` is available on PATH. If not, put the full path to `php.exe` in the scheduled task action or edit `scripts/run-schedule.ps1` and set `$PhpBinary` to the full path (for example `C:\laragon\bin\php\php-8.2.0\php.exe`).
2. Open Task Scheduler → Create Task
   - Name: VMDataTI - Scheduler
   - Run whether user is logged on or not
   - Configure for: Windows 10/11
3. Trigger: New → Begin the task: On a schedule → Daily, Repeat task every: 5 minutes → for a duration of: Indefinitely
4. Action: Start a program
   - Program/script: powershell
   - Add arguments (replace path if your project is elsewhere):
     -NoProfile -ExecutionPolicy Bypass -File "C:\laragon\www\vmdata-ti\scripts\run-schedule.ps1"
5. Conditions/Settings: uncheck "Stop the task if it runs longer than" or adjust to your needs.

Alternative: create via command line (requires admin/appropriate privileges)

```powershell
# Example: create task that runs every 5 minutes (may require elevated prompt)
schtasks /Create /SC MINUTE /MO 5 /TN "VMDataTI Scheduler" /TR "powershell -NoProfile -ExecutionPolicy Bypass -File \"C:\laragon\www\vmdata-ti\scripts\run-schedule.ps1\"" /F
```

Linux (cron)

Add this to the server's crontab (edit with `crontab -e`), replace path with project path and php binary if needed:

```cron
*/5 * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

Notes
- The scheduled task must run as a user that can write to `storage/logs`.
- If you prefer to log to a central location, edit `scripts/run-schedule.ps1` accordingly.
- If `php` is not on PATH in Windows Task Scheduler context, provide full path to `php.exe` in the script or in the Task action.

Want me to register the Task Scheduler entry now?
- I can run the `schtasks /Create ...` command for you here, but it requires an elevated shell and will modify your system Task Scheduler. Tell me if you want me to proceed and confirm you have privileges; otherwise follow the steps above.
Laravel scheduler setup
=======================

This project ships a scheduled Artisan command `rentals:expire` which marks past rentals as `expired`.

What the project added
- `app/Console/Commands/ExpireRentals.php` — the command that updates `vm_rentals` (by `end_time`) and `rentals` (by `end_date`) to `expired` when their end has passed.
- `app/Console/Kernel.php` — registers the command and schedules it to run every five minutes.

How to enable the scheduler on your host

1) Linux / macOS (cron)

- Edit your crontab: `crontab -e`
- Add the line below to run Laravel's scheduler every minute (recommended) or every 5 minutes if you prefer less frequent runs:

  * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1

  # or run every 5 minutes
  */5 * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1

2) Windows (Task Scheduler)

- Open Task Scheduler and create a new basic task.
- Trigger: set it to run every 5 minutes (or 1 minute if you want immediate expirations).
- Action: Start a program.
  - Program/script: full path to your PHP binary (for example: `C:\laragon\bin\php\php8.4.0\php.exe`).
  - Add arguments: `artisan schedule:run`
  - Start in: the project directory (e.g., `C:\laragon\www\vmdata-ti`).

Notes
- The command is idempotent and safe to run frequently. It uses the DB's current time (and Carbon) to compute expirations.
- If your `vm_rentals.status` column is an ENUM in MySQL, a migration was added to include the `expired` value. If that migration fails for your environment, the command will still work because it updates records directly and will fail only when trying to set enum to a non-allowed value. Check `database/migrations/2025_10_22_000000_add_expired_status_to_rentals_tables.php`.
- If you plan to run on a remote server, ensure the PHP CLI binary used by the scheduler is the same PHP version used by the app and has the same extensions available.

Testing the command manually

- Dry run to see counts without applying changes:

  php artisan rentals:expire --dry-run

- Run and apply changes (careful in production):

  php artisan rentals:expire
