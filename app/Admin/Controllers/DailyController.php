<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DailyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '每日';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Daily());

        $grid->column('id', __('Id'));
        $grid->column('Img', __(trans('hhx.Img')))->image();
        $grid->column('collocation', __(trans('hhx.collocation')))->image();
        $grid->column('score', __(trans('hhx.score')));
        $grid->column('grow_up', __(trans('hhx.grow_up')));
        $grid->column('summary', __(trans('hhx.summary')));
        $grid->column('money', __(trans('hhx.money')));
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
        $show = new Show(Daily::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('Img', __(trans('hhx.Img')))->image();
        $show->field('collocation', __(trans('hhx.collocation')))->image();
        $show->field('score', __(trans('hhx.score')));
        $show->field('grow_up', __(trans('hhx.grow_up')));
        $show->field('summary', __(trans('hhx.summary')));
        $show->field('money', __(trans('hhx.money')));
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
        $form = new Form(new Daily());

        $form->image('Img', __(trans('hhx.Img')))->move('public/daily/img')->uniqueName();
        $form->image('collocation', __(trans('hhx.collocation')))->move('public/daily/collocation')->uniqueName();
        $form->number('score', __(trans('hhx.score')))->default(5);
        $form->text('grow_up', __(trans('hhx.grow_up')));
        $form->text('summary', __(trans('hhx.summary')));
        $form->hidden('money', __(trans('hhx.money')))->default(0.00);

        return $form;
    }
}
