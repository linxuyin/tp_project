<?php


namespace app\admin\controller;

use app\admin\common\Paginator;
use app\admin\model\Manager;
use app\admin\model\User;
use think\facade\Db;
use think\facade\View;
use app\BaseController;
use think\Request;

class index extends BaseController {
    public function web() {
        return View::fetch('web_cache');
    }

    public function index(Request $request) {

        $member = Db::table('member')->order('UID')->select();
        return View::fetch('index', ['member' => $member]);
    }

    public function userIndex(Request $request) {
        $user = Db::table('user')->order('UID')->paginate(5);
        //分页显示
        $page = $user->render();
        return View::fetch('user_index', ['user' => $user, 'page' => $page,]);
    }

    public function userUpdate(Request $request) {
        $data = $request->param();
        $user = User::where($data)->select()->toArray();
        return View::fetch('user_up', ['user' => $user]);
    }

    public function doUpdate(Request $request) {
        $data = $request->param();
        $user = User::where(['UID'=>$data['UID']])->find();
        $user->username = $data['username'];
        $user->nickname = $data['nickname'];
        $user->qq = $data['qq'];
        $user->email = $data['email'];
        $user->tel = $data['tel'];
        if($user->save()){
            $this->success('修改成功','index/userUpdate');
        }else{

        }

        dd($user->save());
        $update = User::update($data);

        return View::fetch('user_up', ['user' => $user]);
    }

    //添加用户
    public function userAdd() {
        return View::fetch('user_add');
    }

    public function doUser(Request $request) {
        if ($request->param()) {
            $data = $request->param();
            $a = User::where(['username' => $data['username']])->select()->toArray();
            if (!empty($a)) {
                $this->error('用户名已经存在了', 'index/userAdd');
            }
            $data['password'] = md5($data['password']);
            $data['UID'] = User::count() == 0 ? 1 : User::count() + 1;
            $data['regtime'] = date('Y-m-d H:i:s');
            $insert = User::insert($data);
            if ($insert == 1) {
                $this->success('添加成功', 'index/userIndex');
            } else {
                $this->error('添加失败', 'index/userAdd');
            }
        }
    }

    public function doSearch(Request $request) {
        $condition = [];
        if ($request->param('search')) {
            $condition[] = ['username', 'like', $request->param('search') . '%'];
        }
        $user = User::where($condition)->paginate(5);
        //分页显示
        $page = $user->render();
        return View::fetch('user_index', ['user' => $user, 'page' => $page,]);
    }
}