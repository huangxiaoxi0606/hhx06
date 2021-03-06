<?php

namespace App\Admin\Controllers;

use App\Models\Direction;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DirectionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Direction';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Direction());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('intro', __(trans('hhx.intro')));
        $grid->column('Img', __(trans('hhx.img')))->image();
        $grid->column('status', __(trans('hhx.status')))->using(config('hhx.status'));
        $grid->column('order_num', __(trans('hhx.order_num')));
        $grid->column('all_num', __(trans('hhx.all_num')));
        $grid->column('this_year', __(trans('hhx.this_year')));
        $grid->column('stock', __(trans('hhx.stock')));
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
        $show = new Show(Direction::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('intro', __(trans('hhx.intro')));
        $show->field('Img', __(trans('hhx.img')))->image();
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.status'));
        $show->field('order_num', __(trans('hhx.order_num')));
        $show->field('all_num', __(trans('hhx.all_num')));
        $show->field('stock', __(trans('hhx.stock')));
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
        $form = new Form(new Direction());

        $form->text('name', __(trans('hhx.name')));
        $form->text('intro', __(trans('hhx.intro')));
        $form->image('Img', __(trans('hhx.img')))->move('daily/direction')->uniqueName();
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.status'));;
        $form->number('order_num', __(trans('hhx.order_num')));
        $form->hidden('all_num', __(trans('hhx.all_num')))->default(0.00);
        $form->decimal('stock', __(trans('hhx.stock')));

        return $form;
    }
}
