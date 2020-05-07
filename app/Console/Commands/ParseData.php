<?php

namespace App\Console\Commands;

use App\Models\Daily;
use Illuminate\Console\Command;

class ParseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parseData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理数据';

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
        $daily = Daily::whereNull('date')->get();
        foreach ($daily as $value) {
            $value->date = date("Y-m-d", strtotime($value->created_at));
            $value->save();
        }
        dd('成功');
    }
}
