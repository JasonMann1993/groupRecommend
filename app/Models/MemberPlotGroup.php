<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberPlotGroup extends Model
{
    # 查询群组各小区人数分布情况
    public function plotDistribute($id, $flag)
    {
        $total = $this->where(['group_id' => $id])->count();
        $thisNum = $this->where(['group_id' => $id, 'flag' => $flag])->count();
        if($thisNum == 0){
            return 0;
        }
        $scale = number_format(($thisNum * 100 / $total), 2);
        return $scale;
    }

}
