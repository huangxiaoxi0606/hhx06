<?php

namespace App\Admin\Controllers;

use App\Models\NetEase;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class NetEaseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'NetEase';
    protected $SingNo;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NetEase());

        $grid->column('id', __('Id'));
        $grid->column('singNo', __(trans('hhx.singNo')));
        $grid->column('songUrl', __(trans('hhx.songUrl')));
        $grid->column('singName', __(trans('hhx.singName')));
        $grid->column('songName', __(trans('hhx.songName')));
        $grid->column('localUrl', __(trans('hhx.localUrl')))->video(['server' => env('APP_URL'), 'videoWidth' => 480, 'videoHeight' => 480]);
        $grid->column('SongLyric')->modal(function () {
            $filenames = env('APP_URL') . '/data/' . $this->singName . '/' . $this->songName . '.txt';
            $h = './data/' . $this->singName . '/' . $this->songName . '.txt';
            if (file_exists($h)) {
                $filename = fopen($filenames, "r");
                $data_us = [];
                $num = 0;
                $data_us['歌曲'] = $this->title;
                while (!feof($filename)) {
                    $content = fgets($filename); //逐行取出
                    $num++;
                    $data_us[(string)$num] = $content;
                }
                fclose($filename);
                return new Table(['key', 'value'], $data_us);
            }
        });
        if ($this->SingNo) {
            $grid->model()->where('SingNo', '=', $this->SingNo);
        }
        $grid->disableCreateButton();
        $grid->paginate(10);
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
        $show = new Show(NetEase::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('singNo', __(trans('hhx.singNo')));
        $show->field('songUrl', __(trans('hhx.songUrl')));
        $show->field('singName', __(trans('hhx.singName')));
        $show->field('songName', __(trans('hhx.songName')));
        $show->field('localUrl', __(trans('hhx.localUrl')));
        $show->field('created_at', __(trans('hhx.created_at')));
        $show->field('updated_at', __(trans('hhx.updated_at')));

        return $show;
    }

}
