<?php

namespace App\Admin\Controllers;

use App\Models\DirectionLog;
use App\Services\DailyService;
use App\Services\ServiceManager;
use App\Services\TravelService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class DirectionLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DirectionLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DirectionLog());
        $grid->header(function () {
            $data_s = $this->getDailyService()->getSummaryData();
            $table = new Table(['id', '名称', '月初额度', '已使用', '剩余'], $this->getDailyService()->getSurplus());
            $box = new Box('月度表格 本周:' . $data_s['week'] . '本月:' . $data_s['mouth'], $table);
            $box->removable();
            $box->collapsable();
            $box->style('primary');
            $box->solid();
            return $box;
        });
        $grid->column('id', __('Id'));
        $grid->column('direction_id', __(trans('hhx.direction_id')))->display(function ($direction_id) {
            return $this->getDailyService()->getDirectionName($direction_id);
        });
        $grid->column('daily_id', __(trans('hhx.daily_id')))->display(function ($daily_id) {
            return $this->getDailyService()->getDailyToDate($daily_id);
        });
        $grid->column('status', __(trans('hhx.status')))->using(config('hhx.direction_id_status'));
        $grid->column('ok', __('Ok'))->using(config('hhx.ok'));
        $grid->column('illustration', __(trans('hhx.illustration')));
        $grid->column('money', __(trans('hhx.money')));
        $grid->column('week_day', __(trans('hhx.week_day')))->using(config('hhx.week_day'));
        $grid->column('created_at', __(trans('hhx.created_at')));
        $grid->column('updated_at', __(trans('hhx.updated_at')));
        $grid->model()->orderBy('id', 'desc');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DirectionLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('direction_id', __(trans('hhx.direction_id')))->as(function ($direction_id) {
            return $this->getDailyService()->getDirectionName($direction_id);
        });
        $show->field('daily_id', __(trans('hhx.daily_id')))->as(function ($daily_id) {
            return $this->getDailyService()->getDailyToDate($daily_id);
        });
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.direction_id_status'));
        $show->field('ok', __('Ok'))->using(config('hhx.ok'));
        $show->field('illustration', __(trans('hhx.illustration')));
        $show->field('note', __(trans('hhx.note')));
        $show->field('money', __(trans('hhx.money')));
        $show->field('week_day', __(trans('hhx.week_day')))->using(config('hhx.week_day'));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DirectionLog());

        $form->select('direction_id', __(trans('hhx.direction_id')))->options($this->getDailyService()->getDirectionArray())->required();
        $form->select('daily_id', __(trans('hhx.daily_id')))->options($this->getDailyService()->getDailyArray())->required();
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.direction_id_status'))->default(0);
        $form->select('ok', __('Ok'))->options(config('hhx.ok'))->default(0);
        $form->text('illustration', __(trans('hhx.illustration')))->required();
        $form->text('note', __(trans('hhx.note')))->default('wu');
        $form->decimal('money', __(trans('hhx.money')))->default(0.00)->required();
        $form->select('week_day', __(trans('hhx.week_day')))->options(config('hhx.week_day'))->default($this->getDailyService()->getTodayWeek());
        $form->select('travel_id', __(trans('hhx.hhx_travel_id')))->options($this->getTravelService()->getThereTravel())->default(0);

        return $form;
    }

    protected function getDailyService(): DailyService
    {
        return ServiceManager::getInstance()->dailyService(
            DailyService::class
        );
    }

    protected function getTravelService(): TravelService
    {
        return ServiceManager::getInstance()->travelService(
            TravelService::class
        );
    }
}
