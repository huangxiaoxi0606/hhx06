<?php

namespace App\Admin\Controllers;

use App\Models\Damai;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DamaiController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Damai';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Damai());

        $grid->column('id', __('Id'));
        $grid->column('actors', __(trans('hhx.actors')));
        $grid->column('cityname', __(trans('hhx.cityname')));
        $grid->column('nameNoHtml', __(trans('hhx.nameNoHtml')));
        $grid->column('price_str', __(trans('hhx.price_str')));
        $grid->column('showtime', __(trans('hhx.showtime')));
        $grid->column('venue', __(trans('hhx.venue')));
        $grid->column('showstatus', __(trans('hhx.showstatus')));
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
        $grid->model()->orderBy('id','desc');
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
        $show = new Show(Damai::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('actors', __(trans('hhx.actors')));
        $show->field('cityname', __(trans('hhx.cityname')));
        $show->field('nameNoHtml', __(trans('hhx.nameNoHtml')));
        $show->field('price_str', __(trans('hhx.price_str')));
        $show->field('showtime', __(trans('hhx.showtime')));
        $show->field('venue', __(trans('hhx.venue')));
        $show->field('showstatus', __(trans('hhx.showstatus')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }

}
