<?php
declare(strict_types=1);

namespace App\Controller\admin\v1;

use App\Controller\AbstractController;
use App\Service\BaseService;
use Hyperf\HttpServer\Contract\RequestInterface;

class BaseController extends AbstractController
{
    /**
     * @var string
     */
    public $service = BaseService::class;

    /**
     * 验证token是否合法 allows里面不需要验证
     * @var array
     */
    protected $allows = [];

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
     * @var mixed
     */
    public $block;

    /**
     * @var string
     */
    protected $jwtKeyName = 'JWT_ADMIN_KEY';

    /**
     * @var string
     */
    protected $jwtKeyExp = 'JWT_ADMIN_EXP';

    /**
     * @var string
     */
    protected $jwtKeyAud = 'JWT_ADMIN_AUD';

    /**
     * @var string
     */
    protected $jwtKeyId = 'JWT_ADMIN_ID';

    /**
     * @var string
     */
    protected $jwtKeyIss = 'JWT_ADMIN_ISS';

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->block = $this->setBlock();
    }

    /**
     * 重置属性值
     */
    public function resetAttributes()
    {
        $this->allows = [];
        $this->condition = [];
        $this->select = ['*'];
        $this->orderBy = 'id desc';
        $this->groupBy = '';
        $this->data = [];
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
    public function beforeAction(RequestInterface $request)
    {
        $this->validateIsAllow();
        $this->block->condition = $this->condition;
        $this->block->select    = $this->select;
        $this->block->orderBy   = $this->orderBy;
        $this->block->groupBy   = $this->groupBy;
        $this->block->data      = $this->data;
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
        return $this->block->index($request);
    }

    /**
     * 详情
     * @param RequestInterface $request
     * @return mixed
     */
    public function show(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->block->show($request);
    }

    /**
     * 更新
     * @param RequestInterface $request
     * @return mixed
     */
    public function update(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->block->update($request);
    }

    /**
     * 删除
     * @param RequestInterface $request
     * @return mixed
     */
    public function delete(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->block->delete($request);
    }

    /**
     * 存储
     * @param RequestInterface $request
     * @return mixed
     */
    public function store(RequestInterface $request)
    {
        $this->beforeAction($request);
        return $this->block->store($request);
    }
}