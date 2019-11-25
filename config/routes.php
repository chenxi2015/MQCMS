<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;
use App\Middleware\Auth\AuthMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\api\v1\IndexController@index');

// api接口
Router::addGroup('/api/', function () {
    Router::addGroup('v1/', function () {

        Router::get('index', 'App\Controller\api\v1\IndexController@index');

        // token
        Router::addGroup('token/', function () {
            // 创建token
            Router::post('create', 'App\Controller\api\v1\TokenController@create');
            // 获取token信息
            Router::get('info', 'App\Controller\api\v1\TokenController@index', ['middleware' => [AuthMiddleware::class]]);
        });

        // 标签
        Router::addGroup('tag/', function () {
            Router::get('index', 'App\Controller\api\v1\TagController@index');
            Router::post('store', 'App\Controller\api\v1\TagController@store');
        });

        // 用户
        Router::addGroup('user/', function () {
            Router::get('index', 'App\Controller\api\v1\UserController@index');
            Router::post('store', 'App\Controller\api\v1\UserController@store');
        }, ['middleware' => [AuthMiddleware::class]]);

        // auth
        Router::addGroup('auth/', function () {
            Router::post('login', 'App\Controller\api\v1\AuthController@login');
            Router::post('register', 'App\Controller\api\v1\AuthController@register');
        });
        // 帖子

    });
});

