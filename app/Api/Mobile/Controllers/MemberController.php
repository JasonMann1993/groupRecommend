<?php

namespace App\Api\Mobile\Controllers;


use App\Api\Mobile\Controllers\Common\ErrorCode;
use App\Api\Mobile\Controllers\Common\WXBizDataCrypt;
use App\Api\Mobile\Requests\MemberRequest;
use App\Models\Member;
use GuzzleHttp\Client;

class MemberController extends BaseController
{
    /**
     * @param MemberRequest $request
     * @return array|\Illuminate\Support\Collection|mixed|string
     */
    public function info(MemberRequest $request)
    {
        //  获取openid 和 session_key
        $appId = C('appid', 1);
        $appSecret = C('appsecret', 1);
        if(empty($appId) || empty($appSecret))
            return $this->response->error('配置信息错误', 403);
        $url = 'https://api.weixin.qq.com/sns/jscode2session?';
        $url .= http_build_query([
            'appid' => $appId,
            'secret' => $appSecret,
            'js_code' => $request->get('code'),
            'grant_type' => 'authorization_code'
        ]);
        $client = new Client();
        $res = $client->request('get', $url);
        $userRes = $res->getBody()->getContents();
        $userRes = \GuzzleHttp\json_decode($userRes);
        $userRes = collect($userRes);

        // 解密用户信息
        $sessionKey = $userRes->get('session_key');
        $encryptedData = $request->get('encryptedData');
        $iv = $request->get('iv');
        $pc = new WXBizDataCrypt($appId, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        if($errCode!=0){
            return $this->response->error(ErrorCode::errMessage($errCode),422);
        }
        $data = json_decode($data,true);
        $data = collect($data);
        if($data->get('openId') && $data->get('unionId')){
            $member = Member::where('openid', $data->get('openId'))->first();
            if(!$member){
                $member = new Member();
                $member->openid = $data->get('openId');
                $member->name = $data->get('nickName');
                $member->avatar = $data->get('avatarUrl');
                $member->unionid = $data->get('unionId');
                $member->gender = $data->get('gender');
                $member->longitude = $request->get('longitude');
                $member->latitude = $request->get('latitude');
                $member->save();
            }else{
                if(!$member->unionid){
                    $member->unionid = $data->get('unionId');
                    $member->save();
                }
            }
            return ['code' => 200, 'member_id' => $member->id];
        }
        return ['code' => 500, 'msg' => '获取用户信息失败'];
    }
}
