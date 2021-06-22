<?php

namespace app\admin\controller;

use think\facade\Request;
use think\facade\View;
use think\facade\Db;
use app\BaseController;



class login extends BaseController
{
    public function login() {
            return View::fetch();
    }

    public function doLogin(){
        $data = Request::param();
//        dd($data);
        $manager = Db::table('manager')->where(['name'=>$data['user'],'password'=>md5($data['pwd'])])->select();
        if(count($manager)==1){
            dd($manager);

            $this->success('登录成功','index/index');
        }else{
            $this->error('登录失败，用户名或者密码错误','login/login');
        }
    }
}
