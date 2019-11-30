<?php
declare(strict_types=1);

namespace App\Service;


use App\Model\User;

class UserService extends BaseService
{
    protected $table = 'user';

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public static function getInfoByUsername($username) {
        return User::query()->where('user_name', $username)->first();
    }

    /**
     * 生成密码
     * @param $password
     * @param string $salt
     * @return string
     */
    public static function generatePasswordHash($password, $salt = '') {
        return sha1(substr(md5($password), 0, 16) . $salt);
    }

    /**
     * 初始化一个加盐字符串
     * @param int $cost
     * @return string
     * @throws \Exception
     */
    public static function generateSalt($cost = 13)
    {
        $cost = (int) $cost;
        if ($cost < 4 || $cost > 31) {
            return '';
        }
        // Get a 20-byte random string
        $rand = random_bytes(20);

        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf('$2y$%02d$', $cost);

        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }
}