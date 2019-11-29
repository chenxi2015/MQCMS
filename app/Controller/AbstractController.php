<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Middleware\Auth\AuthMiddleware;
use App\Utils\JWT;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

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
