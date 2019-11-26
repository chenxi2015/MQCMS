<?php
declare(strict_types=1);

namespace App\Service;


use Hyperf\DbConnection\Db;
use Hyperf\Paginator\Paginator;

class BaseService
{
    /**
     * 根据查询结果获取分页列表
     * @param string $table
     * @param int $limit
     * @param array $condition
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public static function getListByPage(string $table, int $limit, array $condition, array $select)
    {
        $tagList = Db::table($table);
        if (!empty($condition)) {
            $tagList = $tagList->where($condition);
        }
        if (!empty($select)) {
            $tagList = $tagList->select($select);
        }
        return $tagList->paginate($limit);
    }

    /**
     * 根据结果数组分页
     * @param $data
     * @param $per_page
     * @param $current_page
     * @return Paginator
     */
    public static function lists($data, $per_page, $current_page)
    {
        return new Paginator($data, $per_page, $current_page);
    }
}