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
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller
 * Class AuthController
 * @package App\Controller\api\v1
 */
class AuthController extends BaseController
{
    public $service = UserService::class;

    /**
     * 注册
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function register(RequestInterface $request)
    {
        $this->validateParam($request, [
            'user_name' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ], 400, '参数错误');

        $userName = $request->input('user_name');
        $password = $request->input('password');
        $ip = $request->getHeader('Host')[0];

        $userInfo = UserService::getInfoByUsername($userName);
        if ($userInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户名已存在');
        }
        $salt = UserService::generateSalt();

        $data = [
            'user_no' => $userName . generateRandomString(6),
            'user_name' => $userName,
            'real_name' => '',
            'phone' => '',
            'avatar' => '',
            'password' => UserService::generatePasswordHash($password, $salt),
            'salt' => $salt,
            'status' => 1,
            'register_time' => time(),
            'register_ip' => $ip,
            'login_time' => time(),
            'login_ip' => $ip,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $this->data = $data;
        $lastInsertId = parent::store($request);

        if (!$lastInsertId) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '注册失败');
        }
        $token = $this->createAuthToken(['id' => $lastInsertId]);
        return $this->response->json(['code' => ErrorCode::OK, 'message' => '注册成功', 'data' => ['token' => $token, 'expire_time' => JWT::$leeway]]);
    }

    /**
     * 账号密码登录
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(RequestInterface $request)
    {
        $this->validateParam($request, [
            'user_name' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ], 400, '参数错误');

        $userName = $request->input('user_name');
        $password = $request->input('password');
        $userInfo = UserService::getInfoByUsername($userName, ['id', 'salt', 'password']);

        if (!$userInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户不存在');
        }

        if ($userInfo->password != UserService::generatePasswordHash($password, $userInfo->salt)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '密码不正确');
        }

        $token = $this->createAuthToken(['id' => $userInfo->id]);
        return $this->response->json(['token' => $token, 'expire_time' => JWT::$leeway]);
    }

}