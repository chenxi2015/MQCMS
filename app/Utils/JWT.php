<?php
declare(strict_types=1);

/**
 * Jwt类
 */
namespace App\Utils;

use App\Exception\BusinessException;
use Firebase\JWT\JWT as BaseJWT;

class JWT extends BaseJWT
{
    /**
     * 加密方式
     */
    const JWT_ALGORITHM_METHOD = 'HS256';

    /**
     * @var int
     */
    public static $leeway = 30;

    /**
     * 解析token获取info数据
     * @param $token
     * @return array|bool|object|string
     */
    public static function getTokenInfo($token)
    {
        if (!$token) {
            return false;
        }
        try {
            $payLoad = self::decode($token, env('JWT_KEY'), [self::JWT_ALGORITHM_METHOD]);
            return $payLoad->sub;

        } catch (\Exception $e) {
            throw new BusinessException($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 更新token
     * @param $token
     * @return array|string
     */
    public static function refreshToken($info)
    {
        try {
            return self::createToken($info);

        } catch (\Exception $e) {
            throw new BusinessException($e->getCode(), $e->getMessage());
        }

    }

    /**
     * 生成token
     * @param $info
     * @return string
     */
    public static function createToken($info)
    {
        $payload = [
            'iss' => 'mqcms', // 签发人
            'iat' => time(), // 过期时间
            'exp' => time() + self::$leeway, // 过期时间
            'sub' => $info, // 主题
        ];
        return self::encode($payload, env('JWT_KEY'), self::JWT_ALGORITHM_METHOD);
    }
}