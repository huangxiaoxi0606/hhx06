<?php

namespace App\Admin\Controllers;

use App\Models\DirectionLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('Id'));
        $grid->column('direction_id', __(trans('hhx.direction_id')))->display(function ($direction_id){
            return app('daily')->getDirectionName($direction_id);
        });
        $grid->column('daily_id', __(trans('hhx.daily_id')))->display(function ($daily_id){
            return app('daily')->getDailyToDate($daily_id);
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
        $show->field('direction_id', __(trans('hhx.direction_id')))->as(function ($direction_id){
            return app('daily')->getDirectionName($direction_id);
        });
        $show->field('daily_id', __(trans('hhx.daily_id')))->as(function ($daily_id){
            return app('daily')->getDailyToDate($daily_id);
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

        $form->select('direction_id', __(trans('hhx.direction_id')))->options(app('daily')->getDirectionArray())->required();
        $form->select('daily_id', __(trans('hhx.daily_id')))->options(app('daily')->getDailyArray())->required();
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.direction_id_status'))->default(0);
        $form->select('ok', __('Ok'))->options(config('hhx.ok'))->default(0);
        $form->text('illustration', __(trans('hhx.illustration')))->required();
        $form->text('note', __(trans('hhx.note')))->default('wu');
        $form->decimal('money', __(trans('hhx.money')))->default(0.00)->required();
        $form->select('week_day', __(trans('hhx.week_day')))->options(config('hhx.week_day'))->default(app('daily')->getTodayWeek());
        $form->select('travel_id', __(trans('hhx.hhx_travel_id')))->options(app('travel')->getThereTravel())->default(0);

        return $form;
    }
}
