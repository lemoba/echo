<?php declare(strict_types=1);

namespace App\Services;

use App\Triats\Singleton;
use EasySwoole\VerifyCode\Conf;
use EasySwoole\VerifyCode\VerifyCode;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;

class verifyCodeService
{
    use Singleton;

    /**
     * @Inject()
     * @var SessionInterface
     */
    private $session;
    /**
     * @param  int  $len
     * @param  int  $fontSize
     * @return mixed
     */
    public function make(int $len = 4, int $fontSize = 25, int $ttl = 5 * 60)
    {
        $config = new Conf();
        $config->setLength($len);
        $config->setFontSize($fontSize);
        $code = new VerifyCode($config);

        // 生成验证码
        $drawCode = $code->DrawCode();
        $codeHash = $drawCode->getCodeHash();

        // 存储验证码
        $codeStr = $drawCode->getImageCode();
        $this->session->set('verifyCode', $codeStr);
        return $drawCode->getImageByte();
    }

    public function checkVerifyCode($userCode)
    {
        $relCode = strtolower($this->session->get('verifyCode'));
        return $relCode == strtolower($userCode);
    }
}