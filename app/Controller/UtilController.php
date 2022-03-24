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

use App\Services\verifyCodeService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * @Controller
 */
class UtilController
{
    /**
     * 生成验证码
     * @GetMapping(path="/kaptcha")
     * @param  ResponseInterface  $response
     * @return mixed
     */
    public function kaptcha(ResponseInterface $response)
    {
        $code = verifyCodeService::getInstance()->make();

        return $response->withHeader('Content-Type', 'image/png')
            ->raw($code);
    }
}
