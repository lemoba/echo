<?php declare(strict_types=1);

namespace App\Controller;

use App\Services\UtilService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use function Hyperf\ViewEngine\view;

/**
 * @Controller()
 */
class RegisterController extends AbstractController
{
    /**
     * @GetMapping(path="/register")
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function index()
    {
        return view('site/register');
    }

    public function register(RequestInterface $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $code = $request->input('code');

        return $password;
    }
}