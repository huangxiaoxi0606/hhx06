<?php

namespace App\Admin\Controllers;

use App\Models\Line;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Line';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Line());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('intro', __(trans('hhx.intro')));
        $grid->column('cover', __(trans('hhx.cover')))->image();
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
        $show = new Show(Line::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('intro', __(trans('hhx.intro')));
        $show->field('cover', __(trans('hhx.cover')));
        $show->field('content', __(trans('hhx.content')))->unescape();
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
        $form = new Form(new Line());

        $form->text('name', __(trans('hhx.name')));
        $form->text('intro', __(trans('hhx.intro')));
        $form->image('cover', __(trans('hhx.cover')))->move('public/lines')->uniqueName();
        $form->editor('content', __(trans('hhx.content')));

        return $form;
    }
}
