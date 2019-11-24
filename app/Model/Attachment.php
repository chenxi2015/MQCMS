<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $attach_url 
 * @property int $user_id 
 * @property int $attach_type 
 * @property \Carbon\Carbon $created_at 
 */
class Attachment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attachment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'attach_url', 'user_id', 'attach_type', 'created_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'attach_type' => 'integer', 'created_at' => 'datetime'];
}