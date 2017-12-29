<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    use SoftDeletes;
    public $typeText = [
        1 => '用户',
        2 => '商家',
    ];

    # 格式化时间
    public function formatTime($created_at)
    {
        $strTime = strtotime($created_at);
        return date('Y', $strTime) . '.' . date('m', $strTime) . '.' . date('d', $strTime);
    }
    # 计算距离
    public function distance($distance)
    {
        if($distance <= 1000){
            return '小于1km';
        }
        $tempNum = number_format($distance / 1000, 2);
        if(($distance/1000) < $tempNum){
            return '小于'. $tempNum .'km';
        }else{
            return '大于' . $tempNum .'km';
        }
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function destroyBusiness()
    {
        $businesses = $this->businesses;
        if(count($businesses)>0){
            foreach($businesses as $business){
                $business->groups()->sync([]);
                $business->delete();
            }
        }
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'member_groups','member_id','group_id');
    }
}
