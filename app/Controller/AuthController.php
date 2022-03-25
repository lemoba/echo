<?php declare(strict_types=1);

namespace App\Controller;

use App\Enums\Enums;
use App\Model\User;
use App\Services\AuthService;
use App\Services\verifyCodeService;
use App\Utils\CodeResponseUtil;
use App\Utils\PasswordUtil;
use App\Utils\RedisUtil;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use function Hyperf\ViewEngine\view;

/**
 * @Controller(prefix="user")
 */
class AuthController extends BaseConroller
{
    /**
     * @GetMapping(path="login")
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function login()
    {
        $request = $this->request->all();
        $data = array_merge($request, ['Token' => PasswordUtil::genToken()]);
        return view('site/login', $data);
    }

    /**
     * @GetMapping(path="register")
     * @param  ResponseInterface  $response
     * @return \Hyperf\ViewEngine\Contract\FactoryInterface|\Hyperf\ViewEngine\Contract\ViewInterface
     */
    public function register(ResponseInterface $response)
    {
        $isLogin = $this->request->input('isLogin');
        return view('site/register', ['isLogin' => $isLogin]);
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
        $rememberMe = $request->input('rememberMe', 0);
        $token = $request->input('token');

        $checkCode = verifyCodeService::getInstance()->checkVerifyCode($code);

        // 验证码错误
        if (!$checkCode) {
            return $this->fail(CodeResponseUtil::VERIFY_CODE_FAIL);
        }

        $user = AuthService::getUserByEmail($email);

        // 邮箱不存在
        if (is_null($user)) {
            return $this->fail(CodeResponseUtil::EMAIL_NOT_EXISTS);
        }

        $isPassword = PasswordUtil::verify($password, $user->password);

        // 密码错误
        if (!$isPassword) {
            return $this->fail();
        }

        $expire = $rememberMe ? Enums::LOGIN_EXPIRE_REMEMBER_ME : Enums::LOGIN_EXPIRE;

        // 登录将登陆凭证存入Redis并设置程ON

        RedisUtil::SETEX(joins($token, $user->email), $expire, 'ON');

        $res = [
            'username' => $user->username,
            'email' => $user->email,
            'header_url' => $user->header_url,
            'token' => $token,
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
        $token = $this->request->input('token');
        $res = RedisUtil::DEL($token);
        return $this->failOrSuceess($res);
    }
}