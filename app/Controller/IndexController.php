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

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;
use Qbhy\HyperfAuth\AuthManager;
use function Hyperf\ViewEngine\view;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{
    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @GetMapping(path="/")
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function index()
    {
        if ($this->auth->guard('session')->check()) {
            $user = $this->auth->guard('session')->user();
        }
        return view('index', ['user' => $user]);
    }
}
