<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Console\Command;

class MakeSupperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:supper-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make A Supper User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = 'add';
        # 手机号
        while (true) {
            $userPhone = $this->ask('请输入手机号');
            if($userPhone)
                break;
        }

        $userIns = new User();
        # Check Exists
        //
        if($userInfo = User::where('phone', $userPhone)->first()) {
            if(!$this->confirm('用户已存在，你可以修改密码')) {
                return;
            }
            $type = 'edit';
            $userIns = $userInfo;
        }
        if($type == 'add') {
            # 用户名
            while (true) {
                $userName = $this->ask('请输入用户名');
                if($userName)
                    break;
            }
        }
        # password
        while (true) {
            $password = $this->secret($type == 'add' ? '请输入密码' : '请输入新密码');
            if($password)
                break;
        }
        if($type == 'add') {
            $userIns->name = $userName;
            $userIns->phone = $userPhone;
            $userIns->accountnumber = '';
            $userIns->codeurl = '';
        }
        $userIns->password = $password;
        \DB::beginTransaction();
        try {
            $userIns->save();
            if(!$userIns->hasRole('developer'))
                $userIns->assignRole('developer');
        } catch (\Exception $errors) {
            \DB::rollBack();
            $this->error('添加失败');

            return;
        }
        \DB::commit();

        $this->info('操作成功');
    }
}
