<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/26
 * Time: 9:32
 */

namespace App\Api\Controllers\Manage\User;


use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\User\BusinessRequest;
use App\Api\TransFormers\Manage\User\BusinessTransformer;
use App\Models\Business;
use App\Models\Member;

class BusinessController extends BaseController
{

    public function index(BusinessRequest $request)
    {
        $keyword = $request->get('keyword');
        $business = Business::query()
            ->where(function ($query) use ($keyword) {
                if(is_numeric($keyword)){
                    $query->where('id',$keyword);
                }elseif($keyword){
                    $query->where('name','like','%'.$keyword.'%');
                }
            })
            ->latest()->orderBy('order')->paginate(10);
        return $this->response->paginator($business, new BusinessTransformer());
    }

    public function store(BusinessRequest $request)
    {
        $data = $request->except('token');
        $member = Member::find($data['member_id']);
        $business = new Business();
        \DB::beginTransaction();
        try{
            $member->type = 2;
            $member->save();
            $business->create($data);
        }catch(\Exception $exception){
            \DB::rollback();
            return $this->response->error($exception->getMessage(),500);
        }
        \DB::commit();
            return $this->response->created();
    }

    public function show(BusinessRequest $request,$id)
    {
        $info = Business::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        return $this->response->item($info,new BusinessTransformer('info'));
    }

    public function update(BusinessRequest $request,$id)
    {
        $info = Business::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        $info->name = $request->get('name');
        $info->desc = $request->get('desc');
        $info->address = $request->get('address');
        $info->talk = $request->get('talk');
        $info->star = $request->get('star');
        $info->member_id = $request->get('member_id');
        $info->logo = $request->get('logo');
        $info->order = $request->get('order');

        $member = Member::find($request->get('member_id'));
        $member->type = 2;
        \DB::beginTransaction();
        try{
            $member->save();
            $info->save();

        }catch(\Exception $exception){
            \DB::rollback();
            return $this->response->error($exception->getMessage(),500);
        }
        \DB::commit();
        return $this->response->created();
    }

    public function destroy(BusinessRequest $request,$id)
    {
        $info = Business::find($id);
        if(!$info)
            return $this->response->errorNotFound();
        \DB::beginTransaction();
        try{
            $info->groups()->sync([]);
            $info->delete();

        }catch(\Exception $exception){
            \DB::rollback();
            return $this->response->error($exception->getMessage(),500);
        }
        \DB::commit();
        return $this->response->noContent();
    }

    public function lists(BusinessRequest $request)
    {
            $lists = Business::latest()->get();
            return $this->response->collection($lists,new BusinessTransformer('lists'));
    }
}