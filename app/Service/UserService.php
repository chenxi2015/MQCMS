<?php
declare(strict_types=1);

namespace App\Service;


use App\Model\User;

class UserService extends BaseService
{
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
}