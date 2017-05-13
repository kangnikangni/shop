<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	//用户登录
    public function login(){
        //判断请求类型
        if(IS_POST){
        	//登录处理
        	$post = I('post.');
        	//加密密码
        	$post['user_pwd'] = getPwd($post['user_pwd']);
        	//校验用户合法
        	if($data = M('User') -> where($post) -> find()){
        		//正常，session持久化，跳转
        		session('user_id',$data['user_id']);
        		session('user_name',$data['user_name']);
        		//判断情况
                if(isset($_GET['tc']) && isset($_GET['ta'])){
                    //指定跳转
                    $this -> success('登录成功',U("{$_GET['tc']}/{$_GET['ta']}"),3);
                }else{
                    $this -> success('登录成功',U('Index/index'),3);
                }
        	}else{
        		$this -> error('用户名或密码错误');
        	}
        }else{
        	$this -> display();
        }
    }
    //用户注册
    public function register(){
        //判断请求类型
        if(IS_POST){
        	//注册功能
        	//dump($_POST);die;
        	$data = D('User') -> create();
        	//判断验证是否成功
        	if($data){
        		//自动验证通过
        		$data['user_pwd'] = getPwd($data['user_pwd']);	//加密密码
        		$data['user_check'] = '1';
        		$data['add_time'] = time();
        		//入库
        		if(D("User") -> add($data)){
        			$this -> success('注册成功',U('login'),3);
        		}else{
        			$this -> error('注册失败');
        		}
        	}else{
        		$this -> error(D('User') -> getError());
        	}
        }else{
        	$this -> display();
        }
    }

    //退出方法
    public function logout(){
    	//清空session
    	session(null);
    	$this -> success('退出成功',U('Index/index'),3);
    }
}