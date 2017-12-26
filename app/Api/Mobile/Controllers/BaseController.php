<?php

namespace App\Api\Mobile\Controllers;

use App\Http\Controllers\Common\UploadController;
use Dingo\Api\Routing\Helpers;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

}