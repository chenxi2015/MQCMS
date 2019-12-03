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
    public static function getInfoByUsername($username, $select=['*']) {
        return User::query()->where('user_name', $username)->select($select)->first();
    }
}