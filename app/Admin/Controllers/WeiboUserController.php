<?php

namespace App\Admin\Controllers;

use App\Models\WeiboUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WeiboUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WeiboUser';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WeiboUser());

        $grid->column('id', __('Id'));
        $grid->column('screen_name', __(trans('hhx.screen_name')));
        $grid->column('avatar_hd', __(trans('hhx.avatar_hd')))->image();
        $grid->column('cover_image_phone', __(trans('hhx.cover_image_phone')))->image();
        $grid->column('description', __(trans('hhx.description')));
        $grid->column('gender', __(trans('hhx.gender')));
        $grid->column('weibo_id', __(trans('hhx.weibo_id')));
        $grid->column('follow_count', __(trans('hhx.follow_count')));
        $grid->column('followers_count', __(trans('hhx.followers_count')));
        $grid->column('statuses_count', __(trans('hhx.statuses_count')));

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
        $show = new Show(WeiboUser::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('avatar_hd', __(trans('hhx.avatar_hd')))->image();
        $show->field('cover_image_phone', __(trans('hhx.cover_image_phone')))->image();
        $show->field('description', __(trans('hhx.description')));
        $show->field('follow_count', __(trans('hhx.follow_count')));
        $show->field('followers_count', __(trans('hhx.followers_count')));
        $show->field('gender', __(trans('hhx.gender')));
        $show->field('weibo_id', __(trans('hhx.weibo_id')));
        $show->field('mbrank', __(trans('hhx.mbrank')));
        $show->field('mbtype', __(trans('hhx.mbtype')));
        $show->field('screen_name', __(trans('hhx.screen_name')));
        $show->field('statuses_count', __(trans('hhx.statuses_count')));
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
        $form = new Form(new WeiboUser());

        $form->text('weibo_id', __(trans('hhx.weibo_id')));
        $form->text('screen_name', __(trans('hhx.screen_name')));

        return $form;
    }
}
