<?php
/**
 * Created by PhpStorm.
 * User: a123
 * Date: 2020-04-11
 * Time: 21:51
 */

namespace App\Console\Commands;


use App\Services\DailyService;
use App\Services\ServiceManager;
use Illuminate\Console\Command;

class Stock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '月初更新额度';

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
        $this->getDailyService()->updateStock();
    }

    protected function getDailyService(): DailyService
    {
        return ServiceManager::getInstance()->dailyService(
            DailyService::class
        );
    }

}