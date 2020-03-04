<?php

namespace App\Admin\Controllers;

use App\Models\HhxConcert;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HhxConcertController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HhxConcert';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HhxConcert());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.concert_name')));
        $grid->column('pic', __(trans('hhx.concert_pic')))->image();
        $grid->column('singer', __(trans('hhx.singer')));
        $grid->column('money', __(trans('hhx.concert_money')));
        $grid->column('show_time', __(trans('hhx.show_time')));
        $grid->column('city', __(trans('hhx.city')));

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
        $show = new Show(HhxConcert::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.concert_name')));
        $show->field('pic', __(trans('hhx.concert_pic')))->image();
        $show->field('singer', __(trans('hhx.singer')));
        $show->field('money', __(trans('hhx.concert_money')));
        $show->field('show_time', __(trans('hhx.show_time')));
        $show->field('city', __(trans('hhx.city')));
        $show->field('addr', __(trans('hhx.addr')));
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
        $form = new Form(new HhxConcert());

        $form->text('name', __(trans('hhx.concert_name')));
        $form->image('pic', __(trans('hhx.concert_pic')))->move('hhx/concert')->uniqueName();
        $form->text('singer', __(trans('hhx.singer')));
        $form->decimal('money', __(trans('hhx.concert_money')));
        $form->datetime('show_time', __(trans('hhx.show_time')))->default(date('Y-m-d H:i:s'));
        $form->text('city', __(trans('hhx.city')));
        $form->text('addr', __(trans('hhx.addr')));

        return $form;
    }
}
