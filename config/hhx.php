<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/6
 * Time: 15:53
 */
return [
    'img_url' => env('APP_URL') . '/storage/',
    'status' => [
        '0' => '打开',
        '1' => '关闭',
    ],
    'week_day' => [
        '0' => '星期日',
        '1' => '星期一',
        '2' => '星期二',
        '3' => '星期三',
        '4' => '星期四',
        '5' => '星期五',
        '6' => '星期六',
    ],
    'direction_id_status' => [
        '0' => '减少',
        '1' => '增加',
    ],
    'ok' => [
        '0' => 'Ok',
        '1' => 'not Ok',
    ],
    'db_status' => [
        '0' => '未看',
        '1' => '已看',
        '2' => '不感兴趣',
    ],
    'to_do_list_status' => [
        '0' => '未完成',
        '1' => '完成',
    ],
    'to_do_list_comment' => [
        '0' => '未定义',
        '1' => '按时完成',
        '2' => '延长时间',
    ],
    'ctrip_status' => [
        '0' => '不更新',
        '1' => '更新',
    ],
    'travel_status' => [
        '0' => '想法',
        '1' => '准备',
        '2' => '未出发',
        '3' => '已出发',
        '4' => '已结束',
    ],
    'traffic_status' => [
        '0' => '未出发',
        '1' => '已出发',
    ],
    'traffic_ok' => [
        '0' => 'ok',
        '1' => 'bad',
    ],
    'equip_status' => [
        '0' => '购买',
        '1' => '已有',
        '2' => '需复查',
        '3' => '复查',
        '4' => '行程结束',
        '5' => '不带',
    ],
    'bill_status' => [
        '0' => '形程未结束',
        '1' => '行程结束',
    ],
    'direction' => [
        1 => 'Love',
        2 => 'Shop',
        3 => 'Product',
        4 => 'Food',
        5 => 'Study',
        6 => 'Travel',
        7 => 'Family',
        8 => 'Coffee',
        9 => 'Extra'
    ],
    'qny' => [
        'url' =>'http://'.env('QINIUYUN_DEFAULT', null)
    ]

];
