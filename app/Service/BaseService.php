<?php
declare(strict_types=1);

namespace App\Service;


use Hyperf\Paginator\Paginator;

class BaseService
{
    // 分页
    public static function lists($data, $per_page, $current_page)
    {
        return new Paginator($data, $per_page, $current_page);
    }
}