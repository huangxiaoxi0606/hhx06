<?php

namespace App\Admin\Controllers;

use App\Models\Direction;
use App\Models\DirectionLog;
use App\Services\DailyService;
use App\Services\ServiceManager;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Encore\HhxEchart\HhxEchart;


class DirectionWeekController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DirectionWeek';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Direction());
        $week_again = date("Y-m-d", strtotime("this week"));
        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('money', __(trans('hhx.money')))->display(function ()use($week_again){
            return DirectionLog::whereBetween('created_at', [$week_again, Carbon::now()])->where('direction_id', $this->id)->sum('money');
        });
        $grid->column('list',__(trans('hhx.list')))->modal('列表',function () use ($week_again) {
            $data = DirectionLog::whereBetween('created_at', [$week_again, Carbon::now()])->where('direction_id', $this->id)->select('illustration', 'money', 'created_at')->get()->toArray();
            return new Table(['说明', '金额', '创建时间'], $data);
        });
        $grid->disableCreateButton();
        $grid->disablePagination();
        $grid->disableFilter();
        $grid->disableActions();
        $grid->disableRowSelector();
        return $grid;
    }

    public function week(Content $content)
    {
        return $content->header('花销分布')
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $data = $this->getDailyService()->getData(1);
                    $dt = [];
                    foreach ($data as $k => $da) {
                        $d['name'] = $k;
                        $d['value'] = $da;
                        $dt[] = $d;
                    }
                    $chartData = [
                        'title' => '本周花销',
                        'legends' => array_keys($data),
                        'seriesName' => '总占比',
                        'seriesData' => $dt
                    ];
                    $options = [
                        'chartId' => 6,
                        'height' => '500px',
                        'chartJson' => json_encode($chartData)
                    ];
                    $column->row(new Box('本周花销', HhxEchart::pie($options)));
                });
                $row->column(4, function (Column $column) {
                    $data = $this->getDailyService()->getData(2);
                    $dt = [];
                    foreach ($data as $k => $da) {
                        $d['name'] = $k;
                        $d['value'] = $da;
                        $dt[] = $d;
                    }
                    $chartData = [
                        'title' => '本月花销',
                        'legends' => array_keys($data),
                        'seriesName' => '总占比',
                        'seriesData' => $dt
                    ];
                    $options = [
                        'chartId' => 7,
                        'height' => '500px',
                        'chartJson' => json_encode($chartData)
                    ];
                    $column->row(new Box('本月花销', HhxEchart::pie($options)));
                });
                $row->column(4, function (Column $column) {
                    $data = $this->getDailyService()->getData(3);
                    $dt = [];
                    foreach ($data as $k => $da) {
                        $d['name'] = $k;
                        $d['value'] = $da;
                        $dt[] = $d;
                    }
                    $chartData = [
                        'title' => '本年花销',
                        'legends' => array_keys($data),
                        'seriesName' => '总占比',
                        'seriesData' => $dt
                    ];
                    $options = [
                        'chartId' => 8,
                        'height' => '500px',
                        'chartJson' => json_encode($chartData)
                    ];
                    $column->row(new Box('本年花销', HhxEchart::pie($options)));
                });
            });
    }
    protected function getDailyService(): DailyService
    {
        return ServiceManager::getInstance()->dailyService(
            DailyService::class
        );
    }

}
