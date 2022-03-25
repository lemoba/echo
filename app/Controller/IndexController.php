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
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use function Hyperf\ViewEngine\view;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{
    /**
     * @GetMapping(path="/")
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function index(RequestInterface $request)
    {
        $token = $request->cookie('token');
        $username = $request->cookie('username');
        $avatar = $request->cookie('header_url');
        $isLogin = false;

        if ($token !== 'null' && $username !== 'null' && $avatar !== 'null') {
            $isLogin = true;
        }
        return view('index', [
            'token' => $token,
            'username' => $username,
            'avatar' => $avatar,
            'isLogin' => $isLogin
        ]);
    }
}
