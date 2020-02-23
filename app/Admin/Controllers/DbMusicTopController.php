<?php

namespace App\Admin\Controllers;

use App\Models\DbMusicTop;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DbMusicTopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DbMusicTop';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DbMusicTop());

        $grid->column('no', __(trans('hhx.no')))->display(function ($no) {
            return 'No.' . $no;
        });
        $grid->column('img', __(trans('hhx.img')))->image();
        $grid->column('title', __(trans('hhx.title')))->display(function () {
            return $this->title . '(' . $this->type . ')';
        });
        $grid->column('sing_name', __(trans('hhx.sing_name')));
        $grid->column('album', __(trans('hhx.album')));
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.db_status'));
        $grid->filter(function ($filter) {
            $filter->like('title', '中文名');
            $filter->like('sing_name', trans('hhx.sing_name'));
            $filter->like('status', trans('hhx.status'))->select(config('hhx.db_status'));
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
        $show = new Show(DbMusicTop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('no', __(trans('hhx.no')));
        $show->field('img', __(trans('hhx.img')))->image();
        $show->field('title', __(trans('hhx.title')));
        $show->field('sing_name', __(trans('hhx.sing_name')));
        $show->field('date', __(trans('hhx.date')));
        $show->field('album', __(trans('hhx.album')));
        $show->field('cd', __(trans('hhx.cd')));
        $show->field('type', __(trans('hhx.type')));
        $show->field('star', __(trans('hhx.star')));
        $show->field('comment', __(trans('hhx.comment')));
        $show->field('intro', __(trans('hhx.intro')));
        $show->field('songs', __(trans('hhx.songs')));
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.db_status'));
        $show->field('pan_code', __(trans('hhx.pan_code')));
        $show->field('pan_url', __(trans('hhx.pan_url')));
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
        $form = new Form(new DbMusicTop());
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.db_status'));
        $form->text('pan_code', __(trans('hhx.pan_code')));
        $form->text('pan_url', __(trans('hhx.pan_url')));

        return $form;
    }
}
