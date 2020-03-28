<?php

namespace App\Jobs;

use App\Models\WeiboUser;
use App\Services\ServiceManager;
use App\Services\WeiboService;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeiboUserPic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->getWeiboService()->parseWeiboUserPic();
    }

    protected function getWeiboService(): WeiboService
    {
        return ServiceManager::getInstance()->weiboService(
            WeiboService::class
        );
    }
}
