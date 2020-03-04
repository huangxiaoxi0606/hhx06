<?php

namespace App\Admin\Controllers;

use App\Models\Note;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NoteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Note';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Note());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
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
        $show = new Show(Note::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
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
        $form = new Form(new Note());

        $form->text('name', __(trans('hhx.name')));
        $form->textarea('editor', __(trans('hhx.content')));

        return $form;
    }
}
