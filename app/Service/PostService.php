<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Post;

class PostService extends BaseService
{
    /**
     * 获取分页下的列表
     * @param int $limit
     * @param array $condition
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public static function getPostListByPage(int $limit=10, array $condition=[], array $select=['*'])
    {
        return self::getListByPage((new Post())->getTable(), $limit, $condition, $select);
    }
}