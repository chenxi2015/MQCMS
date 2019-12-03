<?php


namespace App\Service\Admin;


use App\Model\Admin;
use App\Service\BaseService;

class AuthService extends BaseService
{
    protected $table = 'admin';

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public static function getAdminInfoByUsername($account, $select=['*']) {
        return Admin::query()->where('acount', $account)->select($select)->first();
    }

}