<?php
declare(strict_types=1);

namespace App\Controller\api\v1;

use App\Service\PostService;
use App\Utils\Common;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class PostController extends BaseController
{
    /**
     * @Inject()
     * @var PostService
     */
    public $service;

    /**
     * 获取帖子列表分页
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $type = $request->input('type', 'default'); // 类型： recommend: 推荐 default: 默认

        $this->condition = [
            ['status', '=', 1],
            ['is_publish', '=', 1],
        ];
        if ($type === 'recommend') {
            $this->condition[] = ['is_recommend', '=', 1];
        }
        $this->orderBy = 'id DESC';
        $list = parent::index($request);

        foreach ($list['data'] as $key => &$value) {
            $value['attach_urls'] = $value['attach_urls'] ? json_decode($value['attach_urls'], true) : [];
            $value['relation_tags_list'] = explode(',', $value['relation_tags']);
        }

        $list['data'] = Common::calculateList($request, $list['data']);
        return $list;
    }
}