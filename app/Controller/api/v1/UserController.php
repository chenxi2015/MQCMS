<?php
declare(strict_types=1);

/**
 * 用户控制器
 */
namespace App\Controller\api\v1;

use App\Service\UserService;

class UserController extends BaseController
{
    public $service = UserService::class;

    protected $allows = ['index'];


}