<?php
declare(strict_types=1);

/**
 * auth控制器
 */
namespace App\Controller\api\v1;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\UserService;
use App\Utils\JWT;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * @Controller
 * Class AuthController
 * @package App\Controller\api\v1
 */
class AuthController extends BaseController
{
    /**
     * 注册
     */
    public function register()
    {
        $params = $this->request->all();
        $isValid = \GUMP::is_valid($params, [
            'user_name' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ]);

        if (!($isValid === true)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
        }

        $userInfo = UserService::getInfoByUsername($params['user_name']);

        if ($userInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户名已存在');
        }

    }

    /**
     * 登录
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $params = $this->request->all();
        $isValid = \GUMP::is_valid($params, [
            'user_name' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ]);

        if (!($isValid === true)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
        }

        $userInfo = UserService::getInfoByUsername($params['user_name']);

        if (!$userInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户不存在');
        }

        if ($userInfo->password != UserService::generatePasswordHash($params['password'], $userInfo->salt)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '密码不正确');
        }

        $token = $this->createAuthToken(['id' => $userInfo->id]);
        return $this->response->json(['token' => $token, 'expire_time' => JWT::$leeway]);
    }
}