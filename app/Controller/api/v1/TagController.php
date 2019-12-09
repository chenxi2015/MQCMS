<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Service\TagService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class TagController extends BaseController
{
    /**
     * @Inject()
     * @var TagService
     */
    public $service;

    /**
     * 不需要验证token有效性
     * @var array
     */
    protected $allows = ['index', 'show'];

    /**
     * @param RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 'default');
        if ($type === 'hot') {
            $this->condition[] = ['is_hot', '=', 1];
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

    /**
     * 新增
     * @param RequestInterface $request
     * @param array $data
     * @return mixed
     */
    public function store(RequestInterface $request)
    {
        $this->validateParam($request, [
            'tag_name' => 'required',
        ], 400, '参数错误');

        $data = [
            'tag_name' => $request->input('tag_name'),
            'is_hot' => 0,
            'status' => 1,
            'first_create_user_id' => $this->getUserId()
        ];
        $this->data = $data;
        return parent::store($request);
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function delete(RequestInterface $request)
    {
        $this->validateParam($request, [
            'id' => 'required',
        ], 400, '参数错误');

        $this->condition = ['id' => $request->input('id')];
        return parent::delete($request);
    }
}