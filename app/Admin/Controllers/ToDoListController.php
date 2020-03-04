<?php

namespace App\Admin\Controllers;

use App\Models\ToDoList;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ToDoListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ToDoList';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ToDoList());

        $grid->column('id', __('Id'));
        $grid->column('title', __(trans('hhx.title')));
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.to_do_list_status'));
        $grid->column('good_date', __(trans('hhx.good_date')));
        $grid->column('comment', __(trans('hhx.to_do_list_comment')))->select(config('hhx.to_do_list_comment'));
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
        $show = new Show(ToDoList::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __(trans('hhx.title')));
        $show->field('desc', __(trans('hhx.desc')));
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.to_do_list_status'));
        $show->field('good_date', __(trans('hhx.good_date')));
        $show->field('comment', __(trans('hhx.to_do_list_comment')))->using(config('hhx.to_do_list_comment'));
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
        $form = new Form(new ToDoList());

        $form->text('title', __(trans('hhx.title')));
        $form->text('desc', __(trans('hhx.desc')));
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.to_do_list_comment'))->default(0);
        $form->date('good_date', __(trans('hhx.good_date')))->default(date('Y-m-d'));
        $form->select('comment', __(trans('hhx.to_do_list_comment')))->options(config('hhx.to_do_list_comment'))->default(0);

        return $form;
    }
}
