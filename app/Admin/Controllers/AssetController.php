<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $str;
    protected $title;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */


    protected function grid()
    {
        $grid = new Grid(new Asset());
        $grid->model()->whereType($this->str)->orderBy('id', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('name', __(trans('hhx.name')));
        $grid->column('pic', __(trans('hhx.pic')))->image();
        $grid->column('mold', __(trans('hhx.mold')))->using(Asset::$molds);
        $grid->column('type', __(trans('hhx.type')));
        $grid->column('created_at', __(trans('hhx.created_at')));
        $grid->column('updated_at', __(trans('hhx.updated_at')));
        $grid->filter(function($filter){
            $filter->equal('mold',__(trans('hhx.mold')))->select(Asset::$type[$this->str]);
            $filter->between('created_at',__(trans('hhx.created_at')))->datetime();
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
        $show = new Show(Asset::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(trans('hhx.name')));
        $show->field('pic', __(trans('hhx.pic')))->image();
        $show->field('mold', __(trans('hhx.mold')))->using(Asset::$molds);;
        $show->field('type', __(trans('hhx.type')));
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
        $form = new Form(new Asset());

        $form->text('name', __(trans('hhx.name')));
        $form->image('pic', __(trans('hhx.pic')))->move('public/asset')->uniqueName();
        $form->select('mold', __(trans('hhx.mold')))->options(Asset::$type[$this->str]);
        $form->hidden('type', __(trans('hhx.type')))->value($this->str);

        return $form;
    }
}
