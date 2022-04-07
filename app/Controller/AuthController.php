<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\Services\AuthService;
use App\Services\verifyCodeService;
use App\Utils\CodeResponseUtil;
use App\Utils\PasswordUtil;
use App\Utils\RedisUtil;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Qbhy\HyperfAuth\Annotation\Auth;
use Qbhy\HyperfAuth\AuthManager;
use function Hyperf\ViewEngine\view;

/**
 * @Controller(prefix="user")
 */
class AuthController extends BaseConroller
{
    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @GetMapping(path="login")
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function login()
    {
        return view('site/login');
    }

    /**
     * @GetMapping(path="register")
     * @param  ResponseInterface  $response
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function register(ResponseInterface $response)
    {
        return view('site/register');
    }

    /**
     * @PostMapping(path="doLogin")
     * @return void
     */
    public function doLogin(RequestInterface $request, ResponseInterface $response)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $code = $request->input('code');
        //$rememberMe = $request->input('rememberMe', 0);


        // 验证码
        $checkCode = verifyCodeService::getInstance()->checkVerifyCode($code);

        if (!$checkCode) {
            return $this->fail(CodeResponseUtil::VERIFY_CODE_FAIL);
        }


        // 邮箱
        $user = AuthService::getUserByEmail($email);

        if (is_null($user)) {
            return $this->fail(CodeResponseUtil::EMAIL_NOT_EXISTS);
        }

        // 密码
        $isPassword = PasswordUtil::verify($password, $user->password);

        if (!$isPassword) {
            return $this->fail();
        }
        $res = [
            'username' => $user->username,
            'email' => $user->email,
            'header_url' => $user->header_url,
            'status' => $this->auth->guard('session')->login($user),
        ];
        return $this->success($res);
    }

    /**
     * @PostMapping(path="doRegister")
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function doRegister(RequestInterface $request, ResponseInterface $response)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $code = $request->input('code');
        $checkCode = verifyCodeService::getInstance()->checkVerifyCode($code);
        if (!$checkCode) {
            return $this->fail(CodeResponseUtil::VERIFY_CODE_FAIL);
        }

        $isExists = AuthService::getUserByEmail($email);

        if (! is_null($isExists)) {
            return $this->fail(CodeResponseUtil::EMAIL_EXISTS);
        }

        $user = new User();
        $user->username = '小萌新'.rand(1000, 9999);
        $user->password = PasswordUtil::make($password);
        $user->email = $email;
        $user->header_url = 'https://yanxuan.nosdn.127.net/80841d741d7fa3073e0ae27bf487339f.jpg?imageView&quality=90&thumbnail=64x64';
        $user->save();

        return $this->success([
            'username' => $user->username,
            'header_url' => $user->header_url
        ]);
    }


    /**
     * @PostMapping("logout")
     * @return void
     */
    public function logout()
    {
        $this->auth->guard('session')->logout();
        return $this->success();
    }
}