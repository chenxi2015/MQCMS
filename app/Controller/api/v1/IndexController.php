<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller\api\v1;
use App\Model\Tag;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends BaseController
{
    /**
     * @RequestMapping(path="index", methods="get, post")
     * @return array
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        $tagNameList = [];
        // $tagList = Tag::all();
        // $tagList = Tag::query()->get();
        // $tagList->reject(function ($user) use ($tagNameList) {
        //     array_push($tagNameList, $user->tag_name);
        //     return $tagNameList;
        // });

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
            'tagNameList' => $tagNameList,
            'tagList' => Db::table('tag')->get()
        ];
    }
}
