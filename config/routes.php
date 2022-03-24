<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Controller\DiscussController;
use App\Controller\IndexController;
use App\Controller\LoginController;
use App\Controller\RegisterController;
use App\Controller\ResetPasswordConstroller;
use App\Controller\TestController;
use App\Controller\UtilController;
use Hyperf\HttpServer\Router\Router;

Router::get('/', [IndexController::class, 'index']);
Router::get('/login', [LoginController::class, 'login']);

Router::post('/doRegister', [RegisterController::class, 'register']);
Router::get('/reset-pwd', [ResetPasswordConstroller::class, 'resetPwd']);
Router::get('/child', [TestController::class, 'child']);
Router::get('/discuss/detail', [DiscussController::class, 'detail']);
Router::get('/discuss/publish', [DiscussController::class, 'publish']);

Router::get('/favicon.ico', function () {
    return '';
});
