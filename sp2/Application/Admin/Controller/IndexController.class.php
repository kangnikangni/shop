<?php
namespace Admin\Controller;
class IndexController extends CommonController {
    public function index(){
        $this -> display();
    }

    public function top(){
        $this -> display();
    }

    public function left(){
        //获取菜单
        $role_id = session('role_id');
        //判断例外
        if($role_id == '1'){
            //超级管理员，拥有全部的权限
            $top  = M('Auth') -> where("auth_pid = 0 and is_nav = '1'") -> select(); 
            $cate = M('Auth') -> where("auth_pid != 0 and is_nav = '1'") -> select();
        }else{
            //非超级管理员，菜单根据权限来显示
            //根据角色id查询角色的权限信息
            $roleInfo = M('Role') -> find($role_id);
            $auth_id = $roleInfo['role_auth_ids'];
            //查询权限信息
            $top  = M('Auth') -> where("auth_pid = 0 and is_nav = '1' and auth_id in ($auth_id)") -> select();
            $cate  = M('Auth') -> where("auth_pid != 0 and is_nav = '1' and auth_id in ($auth_id)") -> select();
        }
        //变量分配
        $this -> assign('top',$top);
        $this -> assign('cate',$cate);
        $this -> display();
    }

    public function main(){
        $this -> display();
    }
}