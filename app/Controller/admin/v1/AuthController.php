<?php
declare(strict_types=1);

/**
 * auth控制器
 */
namespace App\Controller\admin\v1;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\Admin\AuthService;
use App\Utils\Common;
use App\Utils\JWT;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller
 * Class AuthController
 * @package App\Controller\admin\v1
 */
class AuthController extends BaseController
{
    public $service = AuthService::class;

    protected $allows = ['register', 'login'];

    /**
     * 注册
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function register(RequestInterface $request)
    {
        $this->validateParam($request, [
            'account' => 'required',
            'phone' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ], 400, '参数错误');

        $account = $request->input('account');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $ip = $request->getHeader('Host')[0];

        $this->select = ['id', 'status', 'avatar'];
        $this->condition = [['account', '=', $account]];
        $adminInfo = parent::show($request);

        if ($adminInfo) {
            if ($adminInfo['status'] == 0) {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '账号已被封禁');
            } else {
                throw new BusinessException(ErrorCode::BAD_REQUEST, '账号已存在，请直接登录');
            }
        }
        // 新建用户
        $salt = Common::generateSalt();
        $data = [
            'account' => $account,
            'password' => Common::generatePasswordHash($password, $salt),
            'phone' => $phone,
            'avatar' => '',
            'status' => 1,
            'salt' => $salt,
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

        return $this->response->json([
            'token' => $token,
            'expire_time' => JWT::$leeway,
            'uuid' => $lastInsertId,
            'info' => [
                'name' => $account,
                'avatar' => '',
                'access' => []
            ]
        ]);
    }

    /**
     * 账号密码登录
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(RequestInterface $request)
    {
        $this->validateParam($request, [
            'account' => 'required',
            'password' => 'required|max_len,100|min_len,6'
        ], 400, '参数错误');

        $account = $request->input('account');
        $password = $request->input('password');

        $this->select = ['id', 'salt', 'avatar', 'password'];
        $this->condition = [['status', '=', 1], ['account', '=', $account]];
        $adminInfo = parent::show($request);

        if (empty($adminInfo)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '账号不存在或被限制登录');
        }

        if ($adminInfo['password'] != Common::generatePasswordHash($password, $adminInfo['salt'])) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '密码不正确');
        }

        $token = $this->createAuthToken(['id' => $adminInfo['id']]);
        return $this->response->json([
            'token' => $token,
            'expire_time' => JWT::$leeway,
            'uuid' => $adminInfo['id'],
            'info' => [
                'name' => $account,
                'avatar' => $adminInfo['avatar'],
                'access' => []
            ]
        ]);
    }

}