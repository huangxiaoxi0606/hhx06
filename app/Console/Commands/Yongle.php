<?php

namespace App\Console\Commands;

use App\Handlers\YongleHandle;
use Illuminate\Console\Command;

class Yongle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:yongle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yongle';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        YongleHandle::getData();
    }
}
