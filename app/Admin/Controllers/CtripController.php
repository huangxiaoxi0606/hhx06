<?php

namespace App\Admin\Controllers;

use App\Models\Ctrip;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CtripController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ctrip';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ctrip());

        $grid->column('id', __('Id'));
        $grid->column('depAirportCode', __(trans('hhx.depAirportCode')));
        $grid->column('arrAirportCode', __(trans('hhx.arrAirportCode')));
        $grid->column('depAirportName', __(trans('hhx.depAirportName')));
        $grid->column('arrAirportName', __(trans('hhx.arrAirportName')));
        $grid->column('minDate', __(trans('hhx.minDate')));
        $grid->column('minPrice', __(trans('hhx.minPrice')));
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.ctrip_status'));
        $grid->column('created_at', __(trans('hhx.created_at')));
        $grid->column('updated_at', __(trans('hhx.updated_at')));
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
        $show = new Show(Ctrip::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('depAirportCode', __(trans('hhx.depAirportCode')));
        $show->field('arrAirportCode', __(trans('hhx.arrAirportCode')));
        $show->field('depAirportName', __(trans('hhx.depAirportName')));
        $show->field('arrAirportName', __(trans('hhx.arrAirportName')));
        $show->field('minDate', __(trans('hhx.minDate')));
        $show->field('minPrice', __(trans('hhx.minPrice')));
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.ctrip_status'));
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
        $form = new Form(new Ctrip());

        $form->text('depAirportCode', __(trans('hhx.depAirportCode')));
        $form->text('arrAirportCode', __(trans('hhx.arrAirportCode')));
        $form->text('depAirportName', __(trans('hhx.depAirportName')));
        $form->text('arrAirportName', __(trans('hhx.arrAirportName')));
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.ctrip_status'));

        return $form;
    }
}
