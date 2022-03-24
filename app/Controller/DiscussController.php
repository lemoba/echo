<?php declare(strict_types=1);

namespace App\Controller;

use function Hyperf\ViewEngine\view;

class DiscussController extends AbstractController
{
    public function publish()
    {
        return view('site/discuss-publish');
    }

    public function detail()
    {
        return view('site/discuss-detail');
    }
}