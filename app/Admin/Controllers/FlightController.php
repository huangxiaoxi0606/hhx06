<?php

namespace App\Admin\Controllers;

use App\Models\Flight;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FlightController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Flight';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Flight());

        $grid->column('id', __('Id'));

        $grid->column('depName', __(trans('hhx.depName')))->display(function () {
            return $this->depName . '(' . $this->depCode . ')';
        });
        $grid->column('arrName', __(trans('hhx.arrName')))->display(function () {
            return $this->arrName . '(' . $this->arrCode . ')';
        });

        $grid->column('price', __(trans('hhx.price')))->display(function () {
            return $this->price . $this->priceDesc;
        })->sortable();

        $grid->column('discount', __(trans('hhx.discount')));
        $grid->column('depDate', __(trans('hhx.depDate')));

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->model()->orderBy('id', 'desc');
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
        $show = new Show(Flight::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('arrCode', __(trans('hhx.arrCode')));
        $show->field('price', __(trans('hhx.price')));
        $show->field('discount', __(trans('hhx.discount')));
        $show->field('arrName', __(trans('hhx.arrName')));
        $show->field('depName', __(trans('hhx.depName')));
        $show->field('depDate', __(trans('hhx.depDate')));
        $show->field('priceDesc', __(trans('hhx.priceDesc')));
        $show->field('depCode', __(trans('hhx.depCode')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }
}
