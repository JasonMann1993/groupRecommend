<?php

namespace App\Api\Mobile\Controllers;

use App\Api\Mobile\Requests\IndexRequest;
use App\Api\Mobile\Transformers\IndexTransformer;
use App\Api\Mobile\Transformers\InfoTransformer;
use App\Models\Group;
use App\Models\MemberPlotGroup;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Text;
use GuzzleHttp\Client;
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
                echo $v.'-';
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

    ## 接收消息
    public function receiveMsg()
    {
        $config = [
            'app_id' => C('appid', 1),
            'secret' => C('appsecret', 1),
        ];
        $app = new Application($config);
        // 从项目实例中得到服务端应用实例。
        $server = $app->server;

        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return "您好！欢迎关注我!";
        });

        $message = $server->getMessage();
        return $message;

        $response = $server->serve();
        //$response->send(); // Laravel 里请使用：return $response;
        return $response;
    }
    
    ## 发送客服消息
    public function sendMsg()
    {
        $config = [
            'app_id' => C('appid', 1),
            'secret' => C('appsecret', 1),
        ];
        $app = new Application($config);

        $openid = 'oZOXt0AJBU07qJstqsebJt4dW208'; // 哈尼
        //$openid = 'oZOXt0JMXyMPA_UMkfV6SKG-60FI'; // 忘忧

        $message = new Image(['media_id' => 'HFQKsKALuBxOfhZNxWBtEYN1gg1PgkSnG1KY9446T2m98zQUgKb1bDQV7PDcAshz']);

        $result = $app->staff->message($message)->to('oZOXt0AJBU07qJstqsebJt4dW208')->send();
        dd($result->toArray());


        //$media_id = 'HFQKsKALuBxOfhZNxWBtEYN1gg1PgkSnG1KY9446T2m98zQUgKb1bDQV7PDcAshz';
        //$res = $this->ImageMsg($openid, $media_id, $url);

        $message = [
            'title' => 'happy day',
            'description' => 'Is Really A Happy Day',
            'url' => 'https://group.network.weixingzpt.com/qrcode',
            'image' => 'http://oss.weixingzpt.com/group_test/j2brYnseoSnxYGp0vXE6365xUMRHHMyZXRBxEyji.jpeg'
        ];

        dd($res);

    }

}
