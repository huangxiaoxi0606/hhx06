<?php

namespace App\Console\Commands;

use App\Handlers\DamaiHandle;
use Illuminate\Console\Command;

class Damai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:damai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Damai';

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
        DamaiHandle::carbonGet();
    }
}
