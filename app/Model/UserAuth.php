<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property string $oauth_id 
 * @property string $union_id 
 * @property string $auth_type 
 * @property string $credential 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserAuth extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_auth';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'oauth_id', 'union_id', 'auth_type', 'credential', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}