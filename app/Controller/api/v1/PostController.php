<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Service\PostService;
use App\Utils\Common;
use Hyperf\HttpServer\Contract\RequestInterface;

class PostController extends BaseController
{
    /**
     * @var string
     */
    public $service = PostService::class;

    /**
     * 获取帖子列表分页
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 'default'); // 类型： recommend: 推荐 default: 默认

        $condition = [
            ['status', '=', 1],
            ['is_publish', '=', 1],
        ];
        if ($type === 'recommend') {
            array_push($condition, ['is_recommend', '=', 1]);
        }

        $list = $this->block->index($request);

        foreach ($list['data'] as $key => &$value) {
            $value['attach_urls'] = $value['attach_urls'] ? json_decode($value['attach_urls'], true) : [];
            $value['relation_tags_list'] = explode(',', $value['relation_tags']);
        }
        $list['data'] = Common::calculateList($request, $list['data']);
        return $this->response->json($list);
    }
}