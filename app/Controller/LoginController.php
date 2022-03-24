<?php declare(strict_types=1);

namespace App\Controller;

use function Hyperf\ViewEngine\view;

class LoginController extends AbstractController
{
    public function login()
    {
        return view('site/login');
    }
}