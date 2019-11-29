<?php
declare(strict_types=1);

namespace App\Utils;


use Hyperf\HttpServer\Contract\RequestInterface;

class Common
{
    /**
     * 构建大小图显示列表 9的倍数 大图6->9 大图13->18 大图24->27 大图31->36 大图42->45 ...
     * @param RequestInterface $request
     * @param array $data
     * @return array
     */
    public static function calculateList(RequestInterface $request, array $data)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 9);
        $page = $page < 1 ? 1 : $page;
        $limit = $limit > 100 ? 100 : $limit;

        $multiple = (($limit / 3) - 1) / 2; // limit的数量 9 15 21 27...
        $suffix = $page % 2 === 0 ? 3 : 5;
        $currentKey = floor($limit-$suffix * $multiple);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data[$key]['img_status'] = 0; // 小图
                if (count($data) >= $limit) {
                    $data[$currentKey-1]['img_status'] = 1; // 大图
                }
            }
        }
        return array_values($data);
    }
}