<?php

namespace App\Admin\Controllers;

use App\Models\InterestLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InterestLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'InterestLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InterestLog());

        $grid->column('id', __('Id'));
        $grid->column('interest_id', __(trans('hhx.interest_id')))->display(function ($interest_id){
            return app('daily')->getInterestName($interest_id);
        });
        $grid->column('daily_id', __(trans('hhx.daily_id')))->display(function ($daily_id){
            return app('daily')->getDailyToDate($daily_id);
        });
        $grid->column('illustration', __(trans('hhx.illustration')));
        $grid->column('week_day', __(trans('hhx.week_day')))->using(config('hhx.week_day'));
        $grid->column('created_at', __(trans('hhx.created_at')));
        $grid->column('updated_at', __(trans('hhx.updated_at')));

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
        $show = new Show(InterestLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('interest_id', __(trans('hhx.interest_id')))->as(function ($interest_id){
            return app('daily')->getInterestName($interest_id);
        });
        $show->field('daily_id', __(trans('hhx.daily_id')))->as(function ($daily_id){
            return app('daily')->getDailyToDate($daily_id);
        });
        $show->field('illustration', __(trans('hhx.illustration')));
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
        $form = new Form(new InterestLog());

        $form->select('interest_id', __(trans('hhx.interest_id')))->options(app('daily')->getInterestArray());
        $form->select('daily_id', __(trans('hhx.daily_id')))->options(app('daily')->getDailyArray());
        $form->text('illustration', __(trans('hhx.illustration')));
        $form->select('week_day', __(trans('hhx.week_day')))->options(config('hhx.week_day'))->default(app('daily')->getTodayWeek());

        return $form;
    }
}
