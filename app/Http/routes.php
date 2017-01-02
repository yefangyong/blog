<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

////基础路由
//Route::get('basic1',function() {
//    return 'hello word';
//});
//
//Route::post('basic2',function() {
//    return 'basic2';
//});
////多路由
//Route::match(['get','post'],'mutly1',function() {
//    return 'mutly';
//});
//
//Route::any('mutly2',function() {
//   return 'mutly2';
//});
//
////路由参数
//Route::get('user/{id}',function($id){
//   return 'user' . $id;
//});

//Route::get('user/{id}/{name}',function($id,$name='yfy'){
//   return 'user='.$id.'name='.$name;
//})->where(['id'=>'[0-9]+','name'=>'[a-zA-Z]+']);

//路由别名
//Route::get('user/center',['as'=>'center',function(){
//    return route('center');
//}]);

////路由群组
//Route::group(['prefix'=>'member'],function(){
//    Route::get('user/center',['as'=>'center',function(){
//        return route('center');
//    }]);
//    Route::any('mutly2',function() {
//     return 'mutly2';
//    });
//});

//路由和控制器关联
//Route::get('member/info','MemberController@info');
//Route::any('member/{id}',['uses'=>'MemberController@info'])->where('id','[0-9]+');
//Route::get('section1','StudentController@section1');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/




//Route::group(['middleware' => ['web']], function () {
//    Route::any('admin/login','Admin\LoginController@login');
//    Route::get('admin/code','Admin\LoginController@code');
//});
//Route::group(['middleware' => ['web','admin.login']], function () {
//    Route::any('admin/index','Admin\IndexController@index');
//    Route::any('admin/info','Admin\IndexController@info');
//});
Route::group(['middleware' => ['web']], function () {

//    Route::get('/', function () {
//        return view('welcome');
//    });
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
    Route::get('/a/{art_id}','Home\IndexController@article');


    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass','IndexController@pass');

    Route::post('cate/changeOrder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');

    Route::resource('article','ArticleController');

    Route::post('links/changeOrder','LinksController@changeOrder');
    Route::resource('links','LinksController');

    Route::resource('navs','NavsController');
    Route::post('navs/changeOrder','NavsController@changeOrder');

    Route::get('config/putfile','ConfigController@putFile');
    Route::post('config/changeOrder','ConfigController@changeOrder');
    Route::post('config/changeContent','ConfigController@changeContent');
    Route::resource('config','ConfigController');
    Route::any('upload','CommonController@upload');
});
////
////分组路由，资源路由
//Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware' => ['web','admin.login']],function(){
//    Route::get('index','IndexController@index');
//    Route::resource('article','ArticleController');
//});


