<?php declare(strict_types=1);

namespace App\Controller;

use function Hyperf\ViewEngine\view;

class ResetPasswordConstroller extends AbstractController
{
    public function resetPwd()
    {
        return view('site/reset-pwd');
    }
}