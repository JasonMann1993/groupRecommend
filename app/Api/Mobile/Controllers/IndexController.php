<?php

namespace App\Api\Mobile\Controllers;

use App\Api\Mobile\Requests\IndexRequest;
use App\Api\Mobile\Transformers\IndexTransformer;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends BaseController
{
    # 首页
    public function index(IndexRequest $request)
    {
        $lng = $request->get('longitude');
        $lat = $request->get('latitude');
        $pageNow = $request->get('page', 1);
        $pageSize = 10;
        $where = [
            ['id', '>', '0']
        ];
        $res = app(Group::class)->getNearLists($lng, $lat, $where);
        $list = new LengthAwarePaginator($res->forPage($pageNow, $pageSize), $res->count(), $pageSize);
        return $this->response->paginator($list, new IndexTransformer());
    }
}