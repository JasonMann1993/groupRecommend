<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/26
 * Time: 9:34
 */

namespace App\Api\Requests\Manage\User;


use App\Api\Requests\Manage\BaseRequest;
use Illuminate\Validation\Rule;

class BusinessRequest extends BaseRequest
{
    public function storeRules()
    {
        return [
            'name'=>'required',
            'desc'=>'required',
            'address'=>'required',
            'talk'=>['required',Rule::in(1,2)],
            'member_id'=>['required',
                    Rule::exists('members','id')->where(function($query){
                        $query->whereNull('deleted_at');
                    })
                ],
            'logo'=>'required',
            'star'=>['required',Rule::in(1,2,3,4,5)],
            'order'=>'required|numeric',
        ];
    }

    public function updateRules()
    {
        return [
            'name'=>'required',
            'desc'=>'required',
            'address'=>'required',
            'talk'=>['required',Rule::in(1,2)],
            'member_id'=>['required',
                Rule::exists('members','id')->where(function($query){
                    $query->whereNull('deleted_at');
                })
            ],
            'logo'=>'required',
            'star'=>['required',Rule::in(1,2,3,4,5)],
            'order'=>'required|numeric',
        ];
    }
}