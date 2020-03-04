<?php

namespace App\Admin\Controllers;

use App\Models\DbTop;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DbTopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'DbTop';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DbTop());
        $grid->header(function ($query) {
            $alread = DbTop::whereStatus(1)->count();
            $notyet = DbTop::whereStatus(0)->count();
            $notok = DbTop::whereStatus(2)->count();
            $pan = DbTop::where('pan_url', '<>', '')->count();
            $x = '已看:' . $alread . '<br />未看:' . $notyet . '<br />不感兴趣:' . $notok . '<br />资源:' . $pan;
            return '<div class="alert alert-success" role="alert">' . $x . '</div>';
        });
        $grid->column('no', __(trans('hhx.no')))->display(function ($no) {
            return 'No.' . $no;
        });
        $grid->column('img', __(trans('hhx.img')))->image();
        $grid->column('c_title', __(trans('hhx.c_title')))->display(function () {
            return $this->c_title . ' ' . $this->year;
        });
        $grid->column('rating_num', __(trans('hhx.rating_num')));
        $grid->column('inq', __(trans('hhx.inq')));
        $grid->column('actor', __(trans('hhx.actor')));
        $grid->column('type', __(trans('hhx.type')));
        $grid->column('status', __(trans('hhx.status')))->select(config('hhx.db_status'));
        $grid->filter(function ($filter) {
            $filter->like('c_title', '中文名');
            $filter->like('year', '年');
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
        $show = new Show(DbTop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('no', __(trans('hhx.no')));
        $show->field('img', __(trans('hhx.img')))->image();
        $show->field('c_title', __(trans('hhx.c_title')));
        $show->field('w_title', __(trans('hhx.w_title')));
        $show->field('rating_num', __(trans('hhx.rating_num')));
        $show->field('inq', __(trans('hhx.inq')));
        $show->field('comment_num', __(trans('hhx.comment_num')));
        $show->field('url', __(trans('hhx.url')));
        $show->field('director', __(trans('hhx.director')));
        $show->field('screen_writer', __(trans('hhx.screen_writer')));
        $show->field('actor', __(trans('hhx.actor')));
        $show->field('type', __(trans('hhx.type')));
        $show->field('time_long', __(trans('hhx.time_long')));
        $show->field('release_date', __(trans('hhx.release_date')));
        $show->field('intro', __(trans('hhx.intro')));
        $show->field('year', __(trans('hhx.year')));
        $show->field('status', __(trans('hhx.status')))->using(config('hhx.db_status'));
        $show->field('pan_url', __(trans('hhx.pan_url')));
        $show->field('pan_code', __(trans('hhx.pan_code')));
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
        $form = new Form(new DbTop());
        $form->select('status', __(trans('hhx.status')))->options(config('hhx.db_status'));;
        $form->text('pan_url', __(trans('hhx.pan_url')));
        $form->text('pan_code', __(trans('hhx.pan_code')));

        return $form;
    }
}
