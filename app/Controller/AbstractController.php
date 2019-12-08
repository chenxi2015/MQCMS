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

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Middleware\AuthMiddleware;
use App\Utils\JWT;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
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
    protected   $request;

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
     * @var string
     */
    protected $jwtKeyName = 'JWT_API_KEY';

    /**
     * @var string
     */
    protected $jwtKeyExp = 'JWT_API_EXP';

    /**
     * @var string
     */
    protected $jwtKeyAud = 'JWT_API_AUD';

    /**
     * @var string
     */
    protected $jwtKeyId = 'JWT_API_ID';

    /**
     * @var string
     */
    protected $jwtKeyIss = 'JWT_API_ISS';

    /**
     * @return array
     */
    public function getJwtConfig()
    {
        return [
            'key' => env($this->jwtKeyName),
            'exp' => env($this->jwtKeyExp),
            'aud' => env($this->jwtKeyAud),
            'iss' => env($this->jwtKeyIss)
        ];
    }

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
        $currentPath = $this->getCurrentPath();
        if ($currentPath !== env($this->jwtKeyId)) {
            throw new BusinessException(ErrorCode::UNAUTHORIZED, 'token验证失败');
        }
        return JWT::getTokenInfo($this->getAuthToken(), $this->getJwtConfig());
    }

    /**
     * 创建token
     * @param $info
     * @return string
     */
    public function createAuthToken($info)
    {
        return JWT::createToken($info, $this->getJwtConfig());
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
     * @return bool
     */
    public function validateIsAllow()
    {
        if (empty($this->allows)) {
            $this->validateAuthToken();
        } else {
            $method = $this->getCurrentActionName();
            if (!in_array($method, $this->allows)) {
                $this->validateAuthToken();
            }
        }
        return true;
    }

    /**
     * 获取当前访问的控制器的方法名称
     * @return array|mixed|string
     */
    public function getCurrentActionName() {
        $pathList = explode('/', $this->request->decodedPath());
        $methods = get_class_methods(get_class($this));
        $method = $methods && !empty($pathList) ? array_values(array_intersect($pathList, $methods)) : [];
        $method = !empty($method) && count($method) === 1 ? $method[0] : '';
        return $method;
    }

    /**
     * 获取当前访问目录
     * @return string
     */
    public function getCurrentPath()
    {
        $pathList = explode('/', $this->request->decodedPath());
        $path = !empty($pathList) ? $pathList[0] : '';
        return $path;
    }

    /**
     * 分布式全局唯一ID生成算法
     * @return int
     */
    public function generateSnowId()
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);
        return $generator->generate();
    }

    /**
     * 根据ID反推对应的Meta
     * @param $id
     * @return \Hyperf\Snowflake\Meta
     */
    public function degenerateSnowId($id)
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);

        return $generator->degenerate($id);
    }
}
