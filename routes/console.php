<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Support\DatabaseBackup;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('backup:run', function (DatabaseBackup $backup) {
    $path = $backup->create();

    $this->info('Database backup created: ' . $path);
})->purpose('Create a SQL database backup in storage/app/backups');

Artisan::command('backup:list', function (DatabaseBackup $backup) {
    $files = $backup->files();

    if (empty($files)) {
        $this->warn('No database backups found.');
        return;
    }

    foreach ($files as $file) {
        $this->line(sprintf(
            '%s  %s KB',
            basename($file),
            number_format(filesize($file) / 1024, 2)
        ));
    }
})->purpose('List database backups stored in storage/app/backups');

Schedule::command('backup:run')->dailyAt('02:00');
