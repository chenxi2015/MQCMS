<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Tag;

class TagService extends BaseService
{
    /**
     * 获取分页下的列表
     * @param int $limit
     * @param array $condition
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public static function getTagListByPage(int $limit=10, array $condition=[], array $select=['*'])
    {
        return self::getListByPage((new Tag())->getTable(), $limit, $condition, $select);
    }
}