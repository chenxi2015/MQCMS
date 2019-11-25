<?php
declare(strict_types=1);

namespace App\Controller\api\v1;


use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Service\TagService;

class TagController extends BaseController
{
    /**
     * 获取分页列表
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
        $type = isset($params['type']) ? $params['type'] : 'default'; // 类型： hot: 获取热门的 default: 默认
        $condition = [
            ['status', '=', 1]
        ];
        if ($type === 'hot') {
            array_push($condition, ['is_hot', '=', 2]);
        }
        return $this->response->json(TagService::getTagListByPage($limit, $condition));
    }


}