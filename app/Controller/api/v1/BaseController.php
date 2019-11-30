<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Controller\AbstractController;
use App\Service\BaseService;
use Hyperf\HttpServer\Contract\RequestInterface;

class BaseController extends AbstractController
{
    /**
     * 查询条件
     * @var array
     */
    public $condition = [];

    /**
     * 查询数据
     * @var array
     */
    public $select = ['*'];

    /**
     * 排序
     * @var string
     */
    public $orderBy = 'id desc';

    /**
     * 分组
     * @var string
     */
    public $groupBy = '';

    /**
     * 存储数组
     * @var array
     */
    public $data = [];

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
        $this->block = $this->setBlock();
    }

    /**
     * @return mixed
     */
    public function setBlock()
    {
        return new $this->service();
    }

    /**
     * @param RequestInterface $request
     */
    public function beforeBuildQuery(RequestInterface $request)
    {
        $this->block->condition = $this->condition;
        $this->block->select    = $this->select;
        $this->block->orderBy   = $this->orderBy;
        $this->block->groupBy   = $this->groupBy;
        $this->block->data      = $this->data;
    }

    /**
     * 列表
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $this->beforeBuildQuery($request);
        return $this->block->index($request);
    }

    /**
     * 详情
     * @param RequestInterface $request
     * @return mixed
     */
    public function show(RequestInterface $request)
    {
        $this->beforeBuildQuery($request);
        return $this->block->show($request);
    }

    /**
     * 更新
     * @param RequestInterface $request
     * @return mixed
     */
    public function update(RequestInterface $request)
    {
        $this->beforeBuildQuery($request);
        return $this->block->update($request);
    }

    /**
     * 删除
     * @param RequestInterface $request
     * @return mixed
     */
    public function delete(RequestInterface $request)
    {
        $this->beforeBuildQuery($request);
        return ['result' => $this->block->delete($request)];
    }

    /**
     * 存储
     * @param RequestInterface $request
     * @return mixed
     */
    public function store(RequestInterface $request)
    {
        $this->beforeBuildQuery($request);
        return ['id' => $this->block->store($request)];
    }
}