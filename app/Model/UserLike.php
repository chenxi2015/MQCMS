<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property int $post_id 
 * @property \Carbon\Carbon $created_at 
 */
class UserLike extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_like';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'post_id', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'post_id' => 'integer', 'created_at' => 'datetime'];
}