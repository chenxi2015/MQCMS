<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $first_create_user_id 
 * @property string $tag_name 
 * @property int $is_hot 
 * @property int $status 
 * @property int $used_count 
 * @property string $created_at 
 * @property string $updated_at 
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
    protected $fillable = ['id', 'first_create_user_id', 'tag_name', 'is_hot', 'status', 'used_count', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'first_create_user_id' => 'integer', 'is_hot' => 'integer', 'status' => 'integer', 'used_count' => 'integer'];
}