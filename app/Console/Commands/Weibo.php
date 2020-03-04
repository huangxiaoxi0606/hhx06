<?php

namespace App\Console\Commands;

use App\Handlers\WeiboHandler;
use Illuminate\Console\Command;

class Weibo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weibo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WeiBo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return WeiboHandler::getData();
    }
}
