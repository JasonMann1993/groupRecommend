<?php

namespace App\Api\Controllers\Manage\Home;

use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\Home\BannerRequest;
use App\Api\TransFormers\Manage\Home\BannerTransformer;
use App\Models\Banner;

class BannerController extends BaseController
{

    public function index()
    {
        $lists = Banner::query()->paginate(10);

        return $this->response->paginator($lists, new BannerTransformer());
    }

    public function store(BannerRequest $request)
    {
        $ins = new Banner();
        $ins->name = $request->get('name');
        $ins->picture = $request->get('picture');
        $ins->is_show = $request->get('show', true);
        $ins->coupon_id = $request->get('coupon_id');
        $ins->carousel_time = $request->get('carousel_time', 2) + 0;
        try {
            $ins->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->created();
    }

    public function show(BannerRequest $request, $id)
    {
        $info = Banner::find($id);
        if(!$info)
            return $this->response->errorNotFound();

        return $this->response->item($info, new BannerTransformer('info'));
    }

    public function update(BannerRequest $request, $id)
    {
        $info = Banner::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        $info->name = $request->get('name');
        $info->picture = $request->get('picture');
        $info->coupon_id = $request->get('coupon_id') + 0;
        $info->is_show = $request->get('show');
        $info->carousel_time = $request->get('carousel_time') + 0;
        try {
            $info->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();

    }

    public function destroy(BannerRequest $request, $id)
    {
        $info = Banner::find($id);
        if(!$info)
            return $this->response->errorNotFound();

        try {
            $info->delete();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }

    public function upShow(BannerRequest $request, $id)
    {
        $info = Banner::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        $info->is_show = boolval($request->get('show'));
        try {
            $info->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }
}
