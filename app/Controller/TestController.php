<?php declare(strict_types=1);

namespace App\Controller;

use function Hyperf\ViewEngine\view;

class TestController extends AbstractController
{
    public function child()
    {
        return view('layouts/app');
    }
}