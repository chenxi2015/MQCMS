<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Tag;
use Hyperf\DbConnection\Db;

class TagService extends BaseService
{
    /**
     * 获取分页下的列表
     * @param int $limit
     * @param array $condition
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public static function getTagListByPage(int $limit=10, array $condition=[])
    {
        $tagList = Db::table((new Tag())->getTable());
        if (!empty($condition)) {
            $tagList = $tagList->where($condition);
        }
        return $tagList->paginate($limit);
    }
}