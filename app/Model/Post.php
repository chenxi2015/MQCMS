<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $post_content 
 * @property int $user_id 
 * @property string $link_url 
 * @property string $relation_tags 
 * @property string $address 
 * @property string $address_lat 
 * @property string $address_lng 
 * @property string $attach_urls 
 * @property int $is_publish 
 * @property int $status 
 * @property int $is_recommend 
 * @property \Carbon\Carbon $created_at 
 */
class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'post_content', 'user_id', 'link_url', 'relation_tags', 'address', 'address_lat', 'address_lng', 'attach_urls', 'is_publish', 'status', 'is_recommend', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'is_publish' => 'integer', 'status' => 'integer', 'is_recommend' => 'integer', 'created_at' => 'datetime'];
}