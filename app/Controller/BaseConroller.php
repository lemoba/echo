<?php declare(strict_types=1);

namespace App\Controller;

use App\Utils\CodeResponseUtil;

use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;

class BaseConroller extends AbstractController
{
    protected function codeReturn(array $codeResponse, $data = null, $info = '')
    {
        [$err_no, $err_msg] = $codeResponse;

        $res = ['code' => $err_no, 'msg' => $info ?: $err_msg];

        if (!is_null($data)) {
            if (is_array($data)) {
                $data = array_filter($data, function ($item) {
                    return $item != null;
                });
            }
        }
        $res['data'] = $data;
        return $this->response->json($res);
    }


    protected function success($data = null)
    {
        return $this->codeReturn(CodeResponseUtil::SUCCESS, $data);
    }

    protected function message(array $codeResponse = CodeResponseUtil::SUCCESS)
    {
        return $this->codeReturn($codeResponse);
    }

    protected function fail(array $codeResponse = CodeResponseUtil::FAIL, $info = '')
    {
        return $this->codeReturn($codeResponse, null, $info);
    }

    protected function failOrSuceess($isSuccess, array $codeResponse = CodeResponseUtil::SUCCESS, $data = null, $info = '')
    {
        if ($isSuccess) {
            return $this->success($codeResponse, $data);
        } else {
            return $this->fail($codeResponse, $info);
        }
    }
}