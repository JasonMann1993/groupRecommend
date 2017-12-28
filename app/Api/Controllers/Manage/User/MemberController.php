<?php

namespace App\Api\Controllers\Manage\User;


use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\User\MemberRequest;
use App\Api\TransFormers\Manage\User\MemberTransformer;
use App\Models\Group;
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
            ->latest()->orderBy('order')->paginate(10);
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
        $group = $request->get('group');
        foreach($group as $value){
            if(!Group::find($value)){
                return $this->response->error('id为'.$value.'的群不存在',422);
            }
        }
        $user->name = $request->get('name');
        $user->type = $request->get('type');
        $user->address = $request->get('address');
        $user->latitude = $request->get('latitude');
        $user->longitude = $request->get('longitude');
        $user->active = $request->get('active');
        $user->block = $request->get('block');
        $user->order = $request->get('order',1);
        try {
            $user->save();
            $user->groups()->sync($group);
        } catch (\Exception $exception) {
            return $this->response->error($exception->getMessage(),500);
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
        \DB::beginTransaction();
        try {
            if($user->type=2){
                $user->destroyBusiness();
            }
            $user->delete();
        } catch (\Exception $exception) {
            \DB::rollback();
            return $this->response->error($exception->getMessage(),500);
        }
        \DB::commit();

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

    public function search(MemberRequest $request)
    {
        $keyword = $request->get('keyword');
        $lists = Member::where('name','like','%'.$keyword.'%')->get();
        return $this->response->collection($lists,new MemberTransformer('search'));
    }
}
