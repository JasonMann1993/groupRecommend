<?php

namespace App\Api\Controllers\Manage\User;


use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\User\MemberRequest;
use App\Api\TransFormers\Manage\User\MemberTransformer;
use App\Models\Member;

class MemberController extends BaseController
{
    /**
     * 获取 用户 | 商家 列表
     *
     * @param MemberRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index(MemberRequest $request)
    {
        $keyword = $request->get('keyword');
        $members = Member::query()
            ->where(function ($query) use ($keyword) {
                if(is_numeric($keyword)){
                    $query->where('id',$keyword);
                }elseif($keyword){
                    $query->where('name','like','%'.$keyword.'%');
                }
            })
            ->latest()->paginate(10);
        return $this->response->paginator($members, new MemberTransformer());
    }

    /**
     * 用户详情
     *
     * @param MemberRequest $request
     * @param               $id
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function show(MemberRequest $request, $id)
    {
        $info = Member::where('id', $id)->first();
        if(!$info)
            return $this->response->errorNotFound();

        return $this->response->item($info, new MemberTransformer('info'));
    }

    /**
     * 修改 用户 信息
     *
     * @param MemberRequest $request
     * @param               $id
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function update(MemberRequest $request, $id)
    {
        $user = Member::where('id', $id)->first();
        if(!$user)
            return $this->response->errorNotFound();

        foreach ($user->getAttributes() as $key => $value) {
            if(array_key_exists($key, $user->argus))
                if($value === '')
                    $user->$key = null;
        }

        try {
            $user->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }

    /**
     * 删除用户
     *
     * @param MemberRequest $request
     * @param               $id
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function destroy(MemberRequest $request, $id)
    {
        $user = Member::where('id', $id)->first();
        if(!$user)
            return $this->response->errorNotFound();
        try {
            $user->delete();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }

    public function upBlock(MemberRequest $request, $id)
    {
        $info = Member::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        $info->defriend = boolval($request->get('block'));
        try {
            $info->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }
}
