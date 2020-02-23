<?php

namespace App\Admin\Controllers;

use App\Models\HhxEquip;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HhxEquipController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HhxEquip';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HhxEquip());

        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->display(function ($hhx_travel_id){
            return app('travel')->getNameByTravelId($hhx_travel_id);
        });
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.equip_status'));
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
        $show = new Show(HhxEquip::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->display(function ($hhx_travel_id){
            return app('travel')->getNameByTravelId($hhx_travel_id);
        });
        $show->field('status', __(trans('hhx.status')))->as(config('hhx.equip_status'));
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
        $form = new Form(new HhxEquip());

        $form->text('name', __(trans('hhx.name')));
        $form->select('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->options(app('travel')->getThereTravel());
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.equip_status'))->default(0);

        return $form;
    }
}
