<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Controller\AbstractController;
use App\Service\BaseService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class BaseController extends AbstractController
{
    /**
     * @Inject()
     * @var BaseService
     */
    public $service = BaseService::class;

    /**
     * 验证token是否合法 allows里面不需要验证
     * @var array
     */
    protected $allows = ['index', 'show'];

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
     * 重置属性值
     */
    public function resetAttributes()
    {
        $this->condition = [];
        $this->select = ['*'];
        $this->orderBy = 'id desc';
        $this->groupBy = '';
        $this->data = [];
    }

    /**
     * @param RequestInterface $request
     */
    public function beforeAction(RequestInterface $request)
    {
        $this->validateIsAllow();
        $this->service->condition = $this->condition;
        $this->service->select    = $this->select;
        $this->service->orderBy   = $this->orderBy;
        $this->service->groupBy   = $this->groupBy;
        $this->service->data      = $this->data;
        $this->resetAttributes();
    }

    /**
     * 列表
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->service->index($request);
    }

    /**
     * 详情
     * @param RequestInterface $request
     * @return mixed
     */
    public function show(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->service->show($request);
    }

    /**
     * 更新
     * @param RequestInterface $request
     * @return mixed
     */
    public function update(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->service->update($request);
    }

    /**
     * 删除
     * @param RequestInterface $request
     * @return mixed
     */
    public function delete(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->service->delete($request);
    }

    /**
     * 存储
     * @param RequestInterface $request
     * @return mixed
     */
    public function store(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->service->store($request);
    }
}