<?php
declare(strict_types=1);

namespace App\Utils;


class Common
{
    /**
     * 构建大小图显示列表 9的倍数 大图6->9 大图13->18 大图24->27 大图31->36 大图42->45 ...
     * @param int $page
     * @param int $limit
     * @param array $data
     */
    public static function calculateList(int $page, int $limit, array $data)
    {
        $multiple = (($limit / 3) - 1) / 2; // limit的数量 9 15 21 27...
        $suffix = $page % 2 === 0 ? 3 : 5;
        foreach ($data as $key => $value) {
            if (in_array($suffix, [3, 5])) {
                $data[$limit-$suffix * $multiple]['img_status'] = 1; // 大图
            } else {
                $data[$key]['img_status'] = 0; // 小图
            }
        }
    }
}