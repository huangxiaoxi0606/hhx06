<?php

namespace App\Admin\Controllers;

use App\Models\HhxTravel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use function foo\func;

class HhxTravelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HhxTravel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HhxTravel());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('topic', __(trans('hhx.topic')));
        $grid->column('money', __(trans('hhx.hhx_money')))->modal('账单', function ($model) {
            return new Table(['名字', '状态', '金额'], app('travel')->getTravelBillById($model->id));
        });
        $grid->column('days', __(trans('hhx.days')))->select(config('hhx.travel_status'));
        $grid->column('status', __(trans('hhx.status')));
        $grid->column('travel_start', __(trans('hhx.travel_start')));
        $grid->column('travel_end', __(trans('hhx.travel_end')));

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
        $show = new Show(HhxTravel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('topic', __(trans('hhx.topic')));
        $show->field('money', __(trans('hhx.money')));
        $show->field('days', __(trans('hhx.days')));
        $show->field('nums', __(trans('hhx.nums')));
        $show->field('status', __(trans('hhx.status')))->as(config('hhx.travel_status'));
        $show->field('travel_start', __(trans('hhx.travel_start')));
        $show->field('travel_end', __(trans('hhx.travel_end')));
        $show->field('rating_num', __(trans('hhx.rating_num')));
        $show->field('note', __(trans('hhx.note')))->unescape();
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
        $form = new Form(new HhxTravel());

        $form->text('name', __(trans('hhx.name')));
        $form->text('topic', __(trans('hhx.topic')));
        $form->number('days', __(trans('hhx.days')))->default(0);
        $form->number('nums', __(trans('hhx.nums')))->default(1);
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.travel_status'))->default(0);
        $form->date('travel_start', __(trans('hhx.travel_start')))->default(date('Y-m-d'));
        $form->date('travel_end', __(trans('hhx.travel_end')))->default(date('Y-m-d'));
        $form->text('rating_num', __(trans('hhx.rating_num')));
        $form->editor('note', __(trans('hhx.note')));

        return $form;
    }
}
