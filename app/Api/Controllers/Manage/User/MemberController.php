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
        $type = $request->get('type') + 0;
        $members = Member::query()
            ->where('status', $type)
            ->where(function ($query) use ($keyword) {
                if($keyword)  # Search for keyword
                    $query->where('id', 'like', "%{$keyword}%")
                        ->orWhere('openid', 'like', "%{$keyword}%")
                        ->orWhere('nickname', 'like', "%{$keyword}%");
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
        # 制券奖励
        $user->manufacture_money = $request->get('reward_make_for_re_shop'); # 商家推荐人
        $user->manufacture_shop_money = $request->get('reward_make_for_shop'); # 商家
        # 核销扣款
        $user->reward_cut_use_for_shop = $request->get('reward_cut_use_for_shop');  # 商家
        # 核销奖励
        $user->write_off_member_recommend_money = $request->get('reward_use_for_re_user'); # 用户推荐人
        $user->write_off_shop_recommend_money = $request->get('reward_use_for_re_shop'); # 商家推荐人
        $user->member_recommend_money = $request->get('reward_use_for_user'); # 用户
        $user->shop_write_off_money = $request->get('reward_use_for_shop'); # 商家
        # 制券扣款
        $user->voucher_system_money = $request->get('cut_make_for_shop'); # 商家

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
