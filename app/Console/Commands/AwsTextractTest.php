<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AwsTextractTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:textract';

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
        dump('ai');
    }
}
