<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Service\TagService;
use Hyperf\HttpServer\Contract\RequestInterface;

class TagController extends BaseController
{
    /**
     * 查询条件
     * @var array
     */
    public $condition = [
        ['status', '=', 1]
    ];

    /**
     * 查询数据
     * @var array
     */
    public $select = ['tag_name', 'is_hot', 'status', 'used_count'];

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
     * @var TagService $service
     */
    public $service = TagService::class;


    /**
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 'default');
        if ($type === 'hot') {
            array_push($this->condition, ['is_hot', '=', 1]);
        } else {
            $this->condition = [['status', '=', 1]];
        }
        return parent::index($request);
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function show(RequestInterface $request)
    {
        $this->validateParam($request, [
            'id' => 'required|integer|alpha_numeric'
        ], 400, '参数错误');

        $id = $request->input('id');
        $this->condition = ['id' => $id];
        return parent::show($request);
    }
}