<?php

namespace App\Admin\Controllers;

use App\Models\Ins;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ins';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ins());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('ins_id', __(trans('hhx.ins_id')));
        $grid->column('display_url', __(trans('hhx.display_url')));
        $grid->column('edge_sidecar_to_children_count', __(trans('hhx.edge_sidecar_to_children_count')));
        $grid->column('video_url', __(trans('hhx.video_url')));
        $grid->column('text', __(trans('hhx.ins_text')));
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
        $show = new Show(Ins::findOrFail($id));

        $show->field('id', __(trans('hhx.id')));
        $show->field('name', __(trans('hhx.name')));
        $show->field('ins_id', __(trans('hhx.ins_id')));
        $show->field('display_url', __(trans('hhx.display_url')));
        $show->field('edge_sidecar_to_children_count', __(trans('hhx.edge_sidecar_to_children_count')));
        $show->field('video_url', __(trans('hhx.video_url')));
        $show->field('text', __(trans('hhx.ins_text')));
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
        $form = new Form(new Ins());

        $form->text('name', __(trans('hhx.name')));
        $form->text('ins_id', __(trans('hhx.ins_id')));
        $form->text('display_url', __(trans('hhx.display_url')));
        $form->number('edge_sidecar_to_children_count', __(trans('hhx.edge_sidecar_to_children_count')));
        $form->text('video_url', __(trans('hhx.video_url')));
        $form->text('text', __(trans('hhx.ins_text')));

        return $form;
    }
}
