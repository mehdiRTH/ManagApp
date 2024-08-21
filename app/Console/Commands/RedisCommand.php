<?php

namespace App\Console\Commands;

use App\Jobs\RedisJob;
use Illuminate\Console\Command;

class RedisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-command';

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
        dispatch(new RedisJob())->onQueue('high');
    }
}
