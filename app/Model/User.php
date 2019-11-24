<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $ user_no 
 * @property string $user_name 
 * @property string $real_name 
 * @property string $phone 
 * @property string $avatar 
 * @property string $password 
 * @property string $salt 
 * @property int $status 
 * @property string $register_time 
 * @property string $register_ip 
 * @property string $login_time 
 * @property string $login_ip 
 * @property \Carbon\Carbon $created_at 
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', ' user_no', 'user_name', 'real_name', 'phone', 'avatar', 'password', 'salt', 'status', 'register_time', 'register_ip', 'login_time', 'login_ip', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime'];
}