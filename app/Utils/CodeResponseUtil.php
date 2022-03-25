<?php declare(strict_types=1);

namespace App\Utils;

class CodeResponseUtil
{
    const SUCCESS = [200, '成功'];
    const FAIL = [400, '错误'];
    const VERIFY_CODE_FAIL = [403, '验证码错误❌'];
    const EMAIL_EXISTS = [404, '该邮箱已注册'];
    const EMAIL_NOT_EXISTS = [405, '该邮箱不存在'];
}