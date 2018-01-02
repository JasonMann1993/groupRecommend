<?php

namespace App\Api\Mobile\Controllers;

use App\Api\Mobile\Requests\IndexRequest;
use App\Api\Mobile\Transformers\IndexTransformer;
use App\Api\Mobile\Transformers\InfoTransformer;
use App\Models\Group;
use App\Models\MemberPlotGroup;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends BaseController
{
    ## 首页
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

    ## 群推荐页面
    public function info(IndexRequest $request, $id)
    {
        $group = Group::with('businesses')->with('members')->find($id);
        return $this->response->item($group, new InfoTransformer());
    }

    ## 将用户归类小区
    public function plotMembers(IndexRequest $request)
    {
        $id = $request->get('id');
        $memberId = $request->get('member_id');
        $lng = $request->get('longitude');
        $lat = $request->get('latitude');
        $mpg = MemberPlotGroup::where(['group_id' => $id, 'member_id' => $memberId])->first();
        if(!$mpg){
            $a = ['a', 'b', 'c'];
            $groupIns = Group::find($id);
            foreach($a as $k => $v){
                $lngflag = 'longitude_' . $v;
                $latflag = 'latitude_' . $v;
                $arr[$v] = get_lng_and_lat_distance($groupIns->$latflag, $groupIns->$lngflag, $lat, $lng);
            }
            $temNum = 100000;
            foreach($arr as $k => $v){
                if($k == 'a'){
                    $temNum = $v;
                }
                if($v < $temNum){
                    $temNum = $v;
                }
            }
            if($temNum > 2500){
                $flag = 'd';
            }else{
                foreach($arr as $k => $v){
                    if($temNum == $v){
                        $flag = $k;
                    }
                }
            }
            return $flag;
        }
    }
}
