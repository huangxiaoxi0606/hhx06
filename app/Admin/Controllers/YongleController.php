<?php

namespace App\Admin\Controllers;

use App\Models\Yongle;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class YongleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Yongle';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Yongle());

        $grid->column('id', __('Id'));
        $grid->column('vname', __(trans('hhx.vname')));
        $grid->column('yname', __(trans('hhx.yname')));
        $grid->column('status', __(trans('hhx.yl_status')));
        $grid->column('performer', __(trans('hhx.performer')));
        $grid->column('prices', __(trans('hhx.prices')));
        $grid->column('cityname', __(trans('hhx.cityname')));
        $grid->column('enddate', __(trans('hhx.enddate')));
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
        $show = new Show(Yongle::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('vname', __(trans('hhx.vname')));
        $show->field('yname', __(trans('hhx.yname')));
        $show->field('status', __(trans('hhx.yl_status')));
        $show->field('performer', __(trans('hhx.performer')));
        $show->field('prices', __(trans('hhx.prices')));
        $show->field('cityname', __(trans('hhx.cityname')));
        $show->field('enddate', __(trans('hhx.enddate')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }
}
