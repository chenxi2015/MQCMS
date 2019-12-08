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


    /**
     * 生成密码
     * @param $password
     * @param string $salt
     * @return string
     */
    public static function generatePasswordHash($password, $salt = '') {
        return sha1(substr(md5($password), 0, 16) . $salt);
    }

    /**
     * 初始化一个加盐字符串
     * @param int $cost
     * @return string
     * @throws \Exception
     */
    public static function generateSalt($cost = 13)
    {
        $cost = (int) $cost;
        if ($cost < 4 || $cost > 31) {
            return '';
        }
        // Get a 20-byte random string
        $rand = random_bytes(20);

        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf('$2y$%02d$', $cost);

        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }
}