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
        $lists = Banner::query()->orderBy('order')->paginate(10);

        return $this->response->paginator($lists, new BannerTransformer());
    }

    public function store(BannerRequest $request)
    {
        $ins = new Banner();
        $ins->name = $request->get('name');
        $ins->picture = $request->get('picture');
        $ins->show = $request->get('show', true);
        $ins->content = $request->get('content');
        $ins->order = $request->get('order',0);
        try {
            $ins->save();
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(),500);
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
        if($request->get('picture'))
        $info->picture = $request->get('picture');
        $info->show = $request->get('show');
        $info->order = $request->get('order',0);
        $info->content = $request->get('content','');
        try {
            $info->save();
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(),500);
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
        $info->show = !$info->show;
        try {
            $info->save();
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(),500);
        }

        return $this->returnData(['show'=>$info->show]);
    }
}
