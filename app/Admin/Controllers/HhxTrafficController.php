<?php

namespace App\Admin\Controllers;

use App\Models\HhxTraffic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HhxTrafficController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HhxTraffic';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HhxTraffic());

        $grid->column('id', __('Id'));
        $grid->column('img', __(trans('hhx.img')));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('illustrate', __(trans('hhx.illustrate')));
        $grid->column('money', __(trans('hhx.traffic_money')));
        $grid->column('ok', __(trans('hhx.ok')))->using(config('hhx.traffic_ok'));
        $grid->column('travel_at', __(trans('hhx.travel_at')));
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.traffic_status'));
        $grid->column('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->display(function ($hhx_travel_id){
            return app('travel')->getNameByTravelId($hhx_travel_id);
        });

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
        $show = new Show(HhxTraffic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('img', __(trans('hhx.img')))->move('hhx/traffic')->uniqueName();
        $show->field('name', __(trans('hhx.name')));
        $show->field('illustrate', __(trans('hhx.illustrate')));
        $show->field('money', __(trans('hhx.traffic_money')));
        $show->field('ok', __(trans('hhx.ok')))->as(config('hhx.traffic_ok'));
        $show->field('travel_at', __(trans('hhx.travel_at')));
        $show->field('status', __(trans('hhx.status')))->as(config('hhx.traffic_status'));
        $show->field('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->display(function ($hhx_travel_id){
            return app('travel')->getNameByTravelId($hhx_travel_id);
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HhxTraffic());

        $form->image('img', __(trans('hhx.img')));
        $form->text('name', __(trans('hhx.name')));
        $form->text('illustrate', __(trans('hhx.illustrate')));
        $form->decimal('money', __(trans('hhx.traffic_money')))->default(0.00);
        $form->select('ok', __(trans('hhx.ok')))->options(config('hhx.traffic_ok'))->default(0);
        $form->date('travel_at', __(trans('hhx.travel_at')))->default(date('Y-m-d'));
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.traffic_status'))->default(0);
        $form->hidden('direction_id', __('Direction id'))->value(6);
        $form->select('daily_id', __('Daily id'))->options(app('daily')->getDailyArray())->required();
        $form->select('hhx_travel_id', __(trans('hhx.hhx_travel_id')))->options(app('travel')->getThereTravel());

        return $form;
    }
}
