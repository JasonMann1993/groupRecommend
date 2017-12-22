<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Common\UploadController;
use Dingo\Api\Routing\Helpers;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BaseController extends Controller
{
    use Helpers, UploadController;

    /**
     * 处理文件上传
     * @param Request $request
     * @return array
     */
    public function handleFiles(Request $request)
    {
        $files = $request->file('img');
        $files = is_array($files) ? $files : [$files];
        $uploads = [];
        foreach ($files as $file) {
            $fileName = date('YmdHi') . str_random(6) . '.jpg';
            $uploadRes = $this->uploadFile($fileName, $file);
            if($uploadRes === true)
                array_push($uploads, $fileName);
            else
                return abort(500);
        }
        return $uploads;
    }

    public function getToken()
    {
        $options = [
            'app_id'=>env('WECHAT_APPID'),
            'secret'=>env('WECHAT_SECRET'),
        ];
        $app = new Application($options);
        $accessToken = $app->access_token;
        $token = $accessToken->getToken();
        return $token;
    }

    public function returnDate($data=[])
    {
        return [
            'data'=>$data
        ];
    }
    protected function curl($url, $type = 1, $data = null)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        if ($type == 2):
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        endif;
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//严格校验
        //设置header
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            return 'Error/' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }
//核销员二维码
    public function getqrcode($unique_id)
    {
        $token = $this->getToken();
        //$url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$token;
        $body = [
            'path'=>'pages/bindClerk/bindClerk?unique_id='.$unique_id,
            'width'=>430,
        ];
        $body = json_encode($body);

        $res = $this->curl($url,2,$body);
        $fileName = time().rand(100000,999999).'.png';
        $tmpFile = tempnam('','');
        file_put_contents($tmpFile , $res);
        if($this->uploadFile($fileName,$tmpFile)){
            unlink($tmpFile);
            return env('OSS_ENDPOINT') . env('OSS_PREFIX') . $fileName;
        }
       return false;
    }

    //订单二维码 小程序
    public function orderCode($id)
    {
        $token = $this->getToken();
        //$url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$token;
        $body = [
            'path'=>'pages/clerkPage/clerkPage?id='.$id,
            'width'=>430,
        ];
        $body = json_encode($body);
        $res = $this->curl($url,2,$body);
        $fileName = time().rand(100000,999999).'.png';
        $tmpFile = tempnam('','');
        file_put_contents($tmpFile , $res);
        if($this->uploadFile($fileName,$tmpFile)){
            return env('OSS_ENDPOINT') . env('OSS_PREFIX') . $fileName;
        }
        return false;
    }
    //生成二维码 普通
    public function codeCommon($url)
    {
        $qrCode = QrCode::format('png')->size(400)->margin(1)->generate($url);
        $tmpFile = tempnam('','');
        file_put_contents($tmpFile,$qrCode);
        $fileName = time().str_random(4).'.png';
        if($this->uploadFile($fileName,$tmpFile)){
            unlink($tmpFile);
            return resource_url($fileName);
        }
        return false;
    }
    //关联用户的优惠券二维码
    public function relatedCode($memberId)
    {
        $token = $this->getToken();
        //$url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$token;
        $body = [
            'path'=>'pages/detail/detail?coupon_id=235&user_id='.$memberId,
            'width'=>430,
        ];
        $body = json_encode($body);
        $res = $this->curl($url,2,$body);
        $fileName = time().rand(100000,999999).'.png';
        $tmpFile = tempnam('','');
        file_put_contents($tmpFile , $res);
        if($this->uploadFile($fileName,$tmpFile)){
            return env('OSS_ENDPOINT') . env('OSS_PREFIX') . $fileName;
        }
        return false;
    }

}