<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property string $intro 
 * @property int $like_num 
 * @property int $follow_num 
 * @property int $fans_num 
 * @property int $post_num 
 * @property int $my_like_num 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_info';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'intro', 'like_num', 'follow_num', 'fans_num', 'post_num', 'my_like_num', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'like_num' => 'integer', 'follow_num' => 'integer', 'fans_num' => 'integer', 'post_num' => 'integer', 'my_like_num' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}