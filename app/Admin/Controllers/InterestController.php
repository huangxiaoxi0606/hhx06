<?php

namespace App\Admin\Controllers;

use App\Models\Interest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InterestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Interest';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Interest());
        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('intro', __(trans('hhx.intro')));
        $grid->column('Img', __(trans('hhx.img')))->image();
        $grid->column('status', __(trans('hhx.status')))->using(config('hhx.status'));
        $grid->column('order_num', __(trans('hhx.order_num')));
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
        $show = new Show(Interest::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('intro', __(trans('hhx.intro')));
        $show->field('Img', __(trans('hhx.img')))->image();
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.status'));
        $show->field('order_num', __(trans('hhx.order_num')));
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
        $form = new Form(new Interest());

        $form->text('name', __(trans('hhx.name')));
        $form->text('intro', __(trans('hhx.intro')));
        $form->image('Img', __(trans('hhx.img')));
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.status'));
        $form->number('order_num', __(trans('hhx.order_num')))->default(1);

        return $form;
    }
}
