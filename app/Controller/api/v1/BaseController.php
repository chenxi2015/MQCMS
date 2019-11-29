<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Controller\AbstractController;
use App\Service\BaseService;

class BaseController extends AbstractController
{
    /**
     * @var string
     */
    public $service = BaseService::class;

    /**
     * @var mixed
     */
    public $block;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->block = $this->block();
    }

    /**
     * @return mixed
     */
    public function block()
    {
        return new $this->service();
    }
}