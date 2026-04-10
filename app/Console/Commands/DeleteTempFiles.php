<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteTempFiles extends Command
{
    protected $signature = 'app:delete-temp-files';

    protected $description = 'Delete the temp files from storage';

    public function handle()
    {
        $tempDirectory = storage_path('app/temp');

        if (File::exists($tempDirectory)) {
            $threeHoursAgo = Carbon::now()->subHours(2);
            $files = File::files($tempDirectory);
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $fileModifiedTime = Carbon::createFromTimestamp(File::lastModified($file));
                    if ($fileModifiedTime->lte($threeHoursAgo)) {
                        File::delete($file);
                    }
                }
            }
        }

        $this->info('The temp files has been deleted');
    }
}