<?php
declare(strict_types=1);

/**
 * 用户控制器
 */
namespace App\Controller\api\v1;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;

class UserController extends BaseController
{
    public function index()
    {
        return $this->response->json(['code' => 200, 'token' => $this->getAuthHeaderInfo()]);
    }
}