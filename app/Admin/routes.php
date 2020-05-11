<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('lines', LineController::class);
    $router->resource('daily', DailyController::class);
    $router->resource('interest', InterestController::class);
    $router->resource('interest_log', InterestLogController::class);
    $router->resource('direction', DirectionController::class);
    $router->resource('direction_log', DirectionLogController::class);
    $router->resource('direction_week', DirectionWeekController::class);
    $router->any('direction_log_week', 'DirectionWeekController@week');
    $router->resource('asset', AssetController::class);
    $router->resource('accessories', AccessoriesController::class);
    $router->resource('clothes', ClothesController::class);
    $router->resource('shoes', ShoesController::class);
    $router->resource('product', ProductController::class);
    $router->resource('coffee', CoffeeController::class);
    $router->resource('db_top', DbTopController::class);
    $router->resource('db_music_top', DbMusicTopController::class);
    $router->resource('hhx_concert', HhxConcertController::class);
    $router->resource('hhx_luck', HhxLuckController::class);
    $router->resource('net_ease', NetEaseController::class);
    $router->resource('net_ease_hebe', NetEaseHebeController::class);
    $router->resource('net_ease_jj', NetEaseJjController::class);
    $router->resource('net_ease_yeung', NetEaseYeungController::class);
    $router->resource('net_ease_yoga', NetEaseYegoController::class);
    $router->resource('net_ease_eason', NetEaseEasonController::class);
    $router->resource('net_ease_wqf', NetEaseWqfController::class);
    $router->resource('net_ease_she', NetEaseSheController::class);
    $router->resource('note', NoteController::class);
    $router->resource('luck', LuckController::class);
    $router->resource('to_do_list', ToDoListController::class);
    $router->resource('travel_note', TravelNoteController::class);
    $router->resource('damai', DamaiController::class);
    $router->resource('yongle', YongleController::class);
    $router->resource('ctrip', CtripController::class);
    $router->resource('flight', FlightController::class);
    $router->resource('hhx_travel', HhxTravelController::class);
    $router->resource('hhx_traffic', HhxTrafficController::class);
    $router->resource('hhx_equip', HhxEquipController::class);
    $router->resource('hhx_bill', HhxBillController::class);
    $router->resource('weibo', WeiboController::class);
    $router->resource('weibo_user', WeiboUserController::class);
    $router->resource('weibo_hhx', WeiboHhxController::class);
    $router->resource('weibo_yejin', WeiboYejinController::class);
    $router->resource('ins', InsController::class);
    $router->resource('ins_users', InsUserController::class);
});

