<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # 生成开发用户
        $this->makeDevelopUser();
    }

    protected function makeDevelopUser()
    {
        $developUserPhone = '13800138000';
        $developUserPassword = '123456';
        $developUserName = '开发者';
        if(!User::where('phone', $developUserPhone)->first()) {
            $userIns = new User();
            $userIns->phone = $developUserPhone;
            $userIns->name = $developUserName;
            $userIns->password = $developUserPassword;
            $userIns->accountnumber = '';
            $userIns->codeurl = '';
            $userIns->save();
            $userIns->assignRole('developer');
        }
         # factory(App\Models\User::class,101)->create();
//         factory(App\Models\User::class,101)->create();
    }

}
