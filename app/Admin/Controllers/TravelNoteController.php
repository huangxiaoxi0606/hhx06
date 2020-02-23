<?php

namespace App\Admin\Controllers;

use App\Models\TravelNote;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TravelNoteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TravelNote';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TravelNote());

        $grid->column('id', __('Id'));
        $grid->column('Author', __(trans('hhx.Author')));
        $grid->column('Img', __(trans('hhx.Img')))->image();
        $grid->column('Name', __(trans('hhx.name')));
        $grid->column('PublishDate', __(trans('hhx.PublishDate')));
        $grid->column('PictureNumber', __(trans('hhx.PictureNumber')));
        $grid->column('created_at', __(trans('hhx.created_at')));
        $grid->column('updated_at', __(trans('hhx.updated_at')));
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();

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
        $show = new Show(TravelNote::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('Author', __(trans('hhx.Author')));
        $show->field('CommentNumber', __(trans('hhx.CommentNumber')));
        $show->field('Content', __(trans('hhx.Content')));
        $show->field('Img', __(trans('hhx.Img')))->image();
        $show->field('Name', __(trans('hhx.name')));
        $show->field('PublishDate', __(trans('hhx.PublishDate')));
        $show->field('PictureNumber', __(trans('hhx.PictureNumber')));
        $show->field('TravelId', __(trans('hhx.TravelId')));
        $show->field('ViewNumber', __(trans('hhx.ViewNumber')));
        $show->field('Url', __(trans('hhx.Url')));
        $show->field('text', __(trans('hhx.text')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }

}
