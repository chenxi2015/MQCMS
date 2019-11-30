<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * Class TokenController
 * @package App\Controller\api\v1
 */
class TokenController extends BaseController
{
    /**
     * 验证token
     * @return array|bool|object|string
     */
    public function index(RequestInterface $request)
    {
        return $this->validateAuthToken();
    }

    /**
     * 创建token
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(RequestInterface $request)
    {
        $token = $this->createAuthToken(['id' => 1]);
        return ['token' => $token];
    }

}