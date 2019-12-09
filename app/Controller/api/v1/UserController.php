<?php
declare(strict_types=1);

/**
 * 用户控制器
 */
namespace App\Controller\api\v1;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;

class UserController extends BaseController
{
    /**
     * @Inject()
     * @var UserService
     */
    public $service;

    protected $allows = ['index'];


}