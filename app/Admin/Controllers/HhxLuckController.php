<?php

namespace App\Admin\Controllers;

use App\Models\HhxLuck;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HhxLuckController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HhxLuck';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HhxLuck());

        $grid->column('id', __('Id'));
        $grid->column('intro', __(trans('hhx.intro')));

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
        $show = new Show(HhxLuck::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('intro', __(trans('hhx.intro')));
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
        $form = new Form(new HhxLuck());

        $form->text('intro', __(trans('hhx.intro')));
        $form->editor('content', __(trans('hhx.content')));

        return $form;
    }
}
