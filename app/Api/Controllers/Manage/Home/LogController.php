<?php

namespace App\Api\Controllers\Manage\Home;

use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\Home\LogRequest;
use App\Api\TransFormers\Manage\Home\LogTransformer;
use App\Models\Award;
use App\Models\Balance;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;

class LogController extends BaseController
{

    /**
     * 充值记录
     *
     * @param LogRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function topUp(LogRequest $request)
    {
        $time = $request->get('time');
        $userName = $request->get('user_name');
        $userId = $request->get('user_id');
        $lists = Balance::where('type', 1)->where(function ($query) use ($time, $userName, $userId) {
            if($time)
                $query->whereBetween('created_at', $time);
            if($userName)
                $query->whereHas('member', function ($query) use ($userName) {
                    $query->where('nickname', 'like', "%{$userName}%");
                });
            if($userId)
                $query->where('member_id', $userId);
        })->latest();
        if(!$request->get('download')) {
            $totalMoney = clone $lists;
            $totalMoney = $totalMoney->sum('money');
            $lists = $lists->paginate(10);

            return $this->response->paginator($lists, (new LogTransformer())->setArgu('total', $totalMoney));
        }

        $lists = $lists->get();
        Excel::create('商户充值记录下载', function ($excel) use ($lists) {
            $excel->sheet('日志记录', function ($sheet) use ($lists) {
                $data = $lists->map(function ($item) {
                    return [
                        'id'   => $item->id,
                        '商户名称' => $item->member ? $item->member->nickname : '--',
                        '商户ID' => $item->member_id,
                        '金额'   => $item->money,
                        '创建时间' => $item->created_at . '',
                    ];
                });
                $sheet->fromArray($data);
            });
        })->export('xls');

    }

    /**
     * 购券记录
     *
     * @param LogRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function buy(LogRequest $request)
    {
        $time = $request->get('time');
        $userName = $request->get('user_name');
        $userId = $request->get('user_id');
        $lists = Order::query()->whereIn('status', [2, 4])->where(function ($query) use ($time, $userName, $userId) {
            if($time)
                $query->whereBetween('created_at', $time);
            if($userName)
                $query->whereHas('member', function ($query) use ($userName) {
                    $query->where('nickname', 'like', "%{$userName}%");
                });
            if($userId)
                $query->where('member_id', $userId);
        })->latest();
        if(!$request->get('download')) {
            $totalMoney = clone $lists;
            $totalMoney = $totalMoney->sum('money');
            $lists = $lists->paginate(10);

            return $this->response->paginator($lists, (new LogTransformer())->setArgu('total', $totalMoney));
        }

        $lists = $lists->get();
        Excel::create('用户购券记录下载', function ($excel) use ($lists) {
            $excel->sheet('日志记录', function ($sheet) use ($lists) {
                $data = $lists->map(function ($item) {
                    return [
                        'id'   => $item->id,
                        '商户名称' => $item->member ? $item->member->nickname : '--',
                        '商户ID' => $item->member_id,
                        '金额'   => $item->money,
                        '创建时间' => $item->created_at . '',
                    ];
                });
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    /**
     * 提现记录
     *
     * @param LogRequest $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function payoff(LogRequest $request)
    {
        $time = $request->get('time');
        $userName = $request->get('user_name');
        $userId = $request->get('user_id');
        $lists = Award::where('type', 3)->where(function ($query) use ($time, $userName, $userId) {
            if($time)
                $query->whereBetween('created_at', $time);
            if($userName)
                $query->whereHas('member', function ($query) use ($userName) {
                    $query->where('nickname', 'like', "%{$userName}%");
                });
            if($userId)
                $query->orWhere('member_id', $userId);
        })->latest();

        if(!$request->get('download')) {
            $totalMoney = clone $lists;
            $totalMoney = $totalMoney->sum('money');
            $lists = $lists->paginate(10);

            return $this->response->paginator($lists, (new LogTransformer('award'))->setArgu('total', $totalMoney));
        }

        $lists = $lists->get();
        Excel::create('用户提现记录下载', function ($excel) use ($lists) {
            $excel->sheet('日志记录', function ($sheet) use ($lists) {
                $data = $lists->map(function ($item) {
                    return [
                        'id'   => $item->id,
                        '商户ID' => $item->member_id,
                        '商户名称' => $item->merchant ? $item->merchant->nickname : '',
                        '商户ID' => $item->origin_id,
                        '金额'   => $item->money,
                        '创建时间' => $item->created_at . '',
                    ];
                });
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function partner(LogRequest $request)
    {
        $time = $request->get('time');
        $userName = $request->get('user_name');
        $type = $request->get('type');
        $user = auth()->user();
        $lists = Award::where([
            ['member_id', $user->id],
            ['member_type', 2]
        ])->where(function ($query) use ($time, $userName, $type) {
            if($time)
                $query->whereBetween('created_at', $time);
            if($userName)
                $query->whereHas('merchant', function ($query) use ($userName) {
                    $query->where('nickname', 'like', "%{$userName}%");
                });
            if($type)
                $query->where('type', $type);
        })->latest();

        $totalMoney = clone $lists;
        $totalMoney = $totalMoney->sum('money');
        $lists = $lists->paginate(10);

        return $this->response->paginator($lists, (new LogTransformer('partner'))->setArgu('total', $totalMoney));
    }

}
