<?php
declare(strict_types=1);

namespace App\Controller\admin\v1;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
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
        $data = parent::index($request);

        foreach ($data['data'] as $key => &$value) {
            $value['created_at'] = date('Y-m-d H:i:s', $value['created_at']);
            $value['updated_at'] = date('Y-m-d H:i:s', $value['updated_at']);
        }
        return $data;
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
            'is_hot' => 'required',
            'status' => 'required',
        ], 400, '参数错误');

        $data = [
            'tag_name' => $request->input('tag_name'),
            'is_hot' => $request->input('is_hot', 0),
            'status' => $request->input('status', 0),
            'first_create_user_id' => $this->getUserId(),
            'tag_type' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];

        $this->select = ['id'];
        $this->condition = [['tag_name', '=', $data['tag_name']]];
        $tagInfo = parent::show($request);
        if ($tagInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '标签名已经存在');
        }

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

    /**
     * 编辑
     * @param RequestInterface $request
     * @param array $data
     * @return mixed
     */
    public function update(RequestInterface $request)
    {
        $this->validateParam($request, [
            'id' => 'required',
            'tag_name' => 'required',
            'is_hot' => 'required',
            'status' => 'required',
        ], 400, '参数错误');

        $id = $request->input('id');
        $data = [
            'tag_name' => $request->input('tag_name'),
            'is_hot' => $request->input('is_hot', 0),
            'status' => $request->input('status', 0),
            'tag_type' => 1,
            'updated_at' => time(),
        ];

        $this->condition = ['id' => $id];
        $this->data = $data;
        return parent::update($request);
    }
}