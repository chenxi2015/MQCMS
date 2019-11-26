<?php
declare(strict_types=1);

namespace App\Controller\api\v1;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\PostService;
use App\Utils\Common;

class PostController extends BaseController
{
    /**
     * 获取帖子列表分页
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $params = $this->request->all();
        $isValid = \GUMP::is_valid($params, [
            'page' => 'required',
        ]);
        if (!($isValid === true)) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
        }
        $limit = isset($params['limit']) && $params['limit'] <= 20 ? (int)$params['limit'] : 10;
        $type = isset($params['type']) ? $params['type'] : 'default'; // 类型： recommend: 推荐 default: 默认
        $condition = [
            ['status', '=', 1],
            ['is_publish', '=', 1],
        ];
        if ($type === 'recommend') {
            array_push($condition, ['is_recommend', '=', 1]);
        }

        $list = PostService::getPostListByPage($limit, $condition);
        foreach ($list['data'] as $key => &$value) {
            $value['attach_list'] = json_decode($value['attach_urls'], true);
        }
        $list['data'] = Common::calculateList($params['page'], $limit, $list);
        return $this->response->json($list);
    }
}