<?php

namespace App\Api\Controllers\Manage;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers,\Dingo\Api\Routing\Helpers;

    public function returnData(Array $data)
    {
        return [
            'data'=>$data
        ];
    }
}
