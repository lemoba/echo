<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $request;

    public function __construct(ContainerInterface $container, RequestInterface $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->request->cookie('token');
        $username = $this->request->cookie('username');
        $avatar = $this->request->cookie('header_url');
        $isLogin = false;

        if ($token !== 'null' && $username !== 'null' && $avatar !== 'null') {
            $isLogin = true;
        }
        $parseData = $request->getParsedBody();
        $request = $request->withParsedBody(array_merge($parseData, [
            'isLogin' => $isLogin,
            'username' => $username,
            'avatar' => $avatar
        ]));
        return $handler->handle($request);
    }
}