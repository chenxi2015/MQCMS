<?php
declare(strict_types=1);

/**
 * 用户控制器
 */
namespace App\Controller\api\v1;

use Hyperf\HttpServer\Contract\RequestInterface;

class UserController extends BaseController
{
    public function index(RequestInterface $request)
    {
        return $this->response->json(['code' => 200, 'token' => $this->getAuthToken()]);
    }
}