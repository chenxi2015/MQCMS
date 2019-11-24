<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $tag_name 
 * @property int $is_hot 
 * @property int $status 
 * @property int $first_create_user_id 
 * @property int $used_count 
 * @property \Carbon\Carbon $created_at 
 */
class Tag extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'tag_name', 'is_hot', 'status', 'first_create_user_id', 'used_count', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'is_hot' => 'integer', 'status' => 'integer', 'first_create_user_id' => 'integer', 'used_count' => 'integer', 'created_at' => 'datetime'];
}