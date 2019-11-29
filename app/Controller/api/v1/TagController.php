<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Service\TagService;
use Hyperf\HttpServer\Contract\RequestInterface;

class TagController extends BaseController
{
    /**
     * @var TagService $service
     */
    public $service = TagService::class;

    /**
     * 获取分页列表
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 'default');

        $condition = [
            ['status', '=', 1]
        ];
        if ($type === 'hot') {
            array_push($condition, ['is_hot', '=', 1]);
        }
        $this->block->select = ['tag_name', 'is_hot', 'status', 'used_count'];
        $this->block->condition = $condition;

        return $this->response->json($this->block->index($request));
    }


}