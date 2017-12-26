<?php

namespace App\Api\Mobile\Controllers;

use App\Api\Mobile\Requests\BannerRequest;
use App\Api\Mobile\Transformers\BannerTransformer;
use App\Models\Banner;

class BannerController extends BaseController
{
    # 首页banner
    public function index(BannerRequest $request)
    {
        $lists = Banner::where(['show' => 1])->orderBy('order', 'desc')->paginate(4);
        return $this->response->paginator($lists, new BannerTransformer());
    }
}
