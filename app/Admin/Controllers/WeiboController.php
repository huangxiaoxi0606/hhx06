<?php

namespace App\Admin\Controllers;

use App\Models\Weibo;
use App\Models\WeiboPic;
use App\Models\WeiboPics;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Str;
use function test\Mockery\Fixtures\HHVMString;

class WeiboController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Weibo';
    protected $wei_id;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Weibo());
        $grid->column('id', __('Id'));
        $grid->column('weibo_info_id', __(trans('hhx.weibo_info_id')));
        $grid->column('screen_name', __(trans('hhx.screen_name')));
        $grid->column('text', __(trans('hhx.w_text')))->display(function () {
            return $this->text;
        });
        $grid->column('thumbnail_pic', __(trans('hhx.thumbnail_pic')))->image();
        $grid->column('source', __(trans('hhx.source')));
        $grid->column('weibo_created_at', __(trans('hhx.weibo_created_at')));
        $grid->column('repost_id', __(trans('hhx.repost_id')))->expand(function ($model) {
            if ($model->repost_id) {
                $wb = app('weibo')->parseReport($model->repost_id);
                if(!$wb){$wb['data'] = '数据被误删除';}
                return new Table(['key', 'value'], $wb);
            }
        });
        $grid->column('pic_num', __(trans('hhx.pic_num')))->modal('多图', function ($model) {
            $data_u = app('weibo')->parsePicNum($model);
            return new Table(['key', 'value'], $data_u);
        });
        $grid->disableCreateButton();
        $grid->model()->where('is_flag', 0)->orderBy('weibo_created_at', 'desc');
        if ($this->wei_id) {
            $grid->model()->where('weibo_id', $this->wei_id);
        }
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableRowSelector();
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
        $show = new Show(Weibo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('weibo_id', __(trans('hhx.weibo_id')));
        $show->field('screen_name', __(trans('hhx.screen_name')));
        $show->field('text', __(trans('hhx.w_text')))->unescape();
        $show->field('thumbnail_pic', __(trans('hhx.thumbnail_pic')))->image();
        $show->field('source', __(trans('hhx.source')));
        $show->field('weibo_created_at', __(trans('hhx.weibo_created_at')));
        $show->field('comments_count', __(trans('hhx.comments_count')));
        $show->field('attitudes_count', __(trans('hhx.attitudes_count')));
        $show->field('reposts_count', __(trans('hhx.reposts_count')));
        $show->field('scheme', __(trans('hhx.scheme')));
        $show->field('is_flag', __(trans('hhx.is_flag')));
        $show->field('repost_id', __(trans('hhx.repost_id')));
        $show->field('weibo_info_id', __(trans('hhx.weibo_info_id')));
        $show->field('pic_num', __(trans('hhx.pic_num')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }

}
