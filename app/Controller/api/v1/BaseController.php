<?php
declare(strict_types=1);

namespace App\Controller\api\v1;


use App\Controller\AbstractController;
use App\Middleware\Auth\AuthMiddleware;
use App\Utils\JWT;

class BaseController extends AbstractController
{
    /**
     * 获取token
     * @return string
     */
    public function getAuthToken()
    {
        return AuthMiddleware::$authToken;
    }

    /**
     * 验证token并获取token值
     * @return array|bool|object|string
     */
    public function validateAuthToken()
    {
        return JWT::getTokenInfo($this->getAuthToken());
    }

    /**
     * 创建token
     * @param $info
     * @return string
     */
    public function createAuthToken($info)
    {
        return JWT::createToken($info);
    }

}