<?php
declare(strict_types=1);

namespace App\Service;


use App\Exception\BusinessException;
use App\Utils\Common;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Paginator\Paginator;

class BaseService
{
    protected $table = '';

    public $condition = [];

    public $select = ['*'];

    public $orderBy = 'id desc';

    public $groupBy = '';

    /**
     * @param RequestInterface $request
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public function index(RequestInterface $request)
    {
        try {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $page = $page < 1 ? 1 : $page;
            $limit = $limit > 100 ? 100 : $limit;

            Common::writeLog($request->getMethod(), '日志测试', 'error', 'api');

            return self::getListByPage($this->table, (int) $page, (int) $limit, $this->condition, $this->select, $this->orderBy, $this->groupBy);

        } catch (\Exception $e) {
            throw new BusinessException($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 根据查询结果获取分页列表
     * @param string $table
     * @param int $limit
     * @param array $condition
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public static function getListByPage(string $table, int $page, int $limit, array $condition, array $select, string $order_by, string $group_by)
    {
        $query = Db::table($table);
        if (!empty($condition)) {
            $query = $query->where($condition);
        }
        if (!empty($select)) {
            $query = $query->select($select);
        }
        if ($order_by) {
            $query = $query->orderByRaw($order_by);
        }
        if (!empty($group_by)) {
            $query = $query->groupBy(implode(',', $group_by));
        }
        return $query->paginate($limit, $select, 'page', $page)->toArray();
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