<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExtractedField;

class AwsTextractTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:extracted-fields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $deletedCount = ExtractedField::whereDoesntHave('run')->delete();
    }
}
