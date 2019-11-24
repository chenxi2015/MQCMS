<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property int $post_id 
 * @property int $is_comment 
 * @property int $is_like 
 * @property int $is_collect 
 * @property \Carbon\Carbon $created_at 
 */
class UserFollow extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_follow';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'post_id', 'is_comment', 'is_like', 'is_collect', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'post_id' => 'integer', 'is_comment' => 'integer', 'is_like' => 'integer', 'is_collect' => 'integer', 'created_at' => 'datetime'];
}