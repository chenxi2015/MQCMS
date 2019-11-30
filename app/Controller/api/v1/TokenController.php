<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller()
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
        return $this->response->json($this->validateAuthToken());
    }

    /**
     * 创建token
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create()
    {
        $token = $this->createAuthToken(['id' => 1]);
        return $this->response->json(['token' => $token]);
    }

}