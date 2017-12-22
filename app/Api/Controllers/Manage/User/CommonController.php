<?php

namespace App\Api\Controllers\Manage\User;


use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\User\CommonRequest;
use App\Api\TransFormers\Manage\User\CommonTransformer;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommonController extends BaseController
{

    /**
     * 用户登录
     *
     * @param CommonRequest $request
     *
     * @return \Dingo\Api\Http\Response|void
     * @throws \Exception
     */
    public function login(CommonRequest $request)
    {
        $name = $request->get('name');
        # 检查用户名
        $info = User::where('phone', $name)->first();
        try {
            if(!$info)
                throw new \Exception();
            # 解密错误
            $userPassword = decrypt($info->password);
            # 密码错误
            if($request->get('password') != $userPassword)
                throw new \Exception();
            # Make user token
            $token = JWTAuth::fromUser($info);
        } catch (DecryptException $exception) {
            return $this->throwValidationHttpException('你输入的账号或密码有误，请重新输入');
        } catch (\Exception $exception) {
            return $this->throwValidationHttpException('你输入的账号或密码有误，请重新输入');
        }


        # 登陆成功
        return $token;
    }

    /**
     * 刷新 Token
     * @return mixed
     */
    public function tokenRefresh()
    {
        $newToken = JWTAuth::parseToken()->refresh();
        return $newToken;
    }


    public function info()
    {
        $user = auth()->user();

        return $this->response->item($user, new CommonTransformer('info'));
    }

    public function memberInfo()
    {
        $user = auth()->user();

        return $this->response->item($user, new CommonTransformer('memberInfo'));
    }
}
