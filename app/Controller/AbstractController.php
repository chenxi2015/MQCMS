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

use App\Exception\BusinessException;
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
     * @var array
     */
    protected $allows = [];

    /**
     * 获取token
     * @return string
     */
    public function getAuthToken()
    {
        return AuthMiddleware::$authToken;
    }

    /**
     * 验证token有效性并获取token值
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

    /**
     * 获取用户id
     * @return mixed
     */
    public function getUserId()
    {
        $info = $this->validateAuthToken();
        return $info['id'];
    }

    /**
     * 全局参数验证
     * @param RequestInterface $request
     * @param array $valid_method
     * @param int $code
     * @param string $message
     */
    public function validateParam(RequestInterface $request, array $valid_method, int $code, string $message)
    {
        $isValid = \GUMP::is_valid($request->all(), $valid_method);
        if (!($isValid === true)) {
            throw new BusinessException($code, $message);
        }
    }

    /**
     * allows数组中允许的不需要token验证合法
     * @param RequestInterface $request
     * @param $className
     * @return bool
     */
    public function validateIsAllow(RequestInterface $request, $className)
    {
        if (empty($this->allows)) {
            $this->validateAuthToken();
        } else {
            $method = $this->getCurrentActionName($className);
            if (!in_array($method, $this->allows)) {
                $this->validateAuthToken();
            }
        }
        return true;
    }

    /**
     * 获取当前访问的控制器的方法名称
     * @param $className
     * @return array|mixed|string
     */
    public function getCurrentActionName($className) {
        $pathList = explode('/', $this->request->decodedPath());
        $methods = get_class_methods(new $className());
        $method = $methods && !empty($pathList) ? array_values(array_intersect($pathList, $methods)) : [];
        $method = !empty($method) && count($method) === 1 ? $method[0] : '';
        return $method;
    }

}
