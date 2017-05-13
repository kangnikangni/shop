<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-14 10:22:55
 * @Version 1.0.0
 * @Description 公共功能控制器
 */

//声明当前类的命名空间
namespace Admin\Controller;
//引入对应的类元素
use Think\Controller;
//声明类并且继承基类
class PublicController extends Controller{

	/**
	 * @Author   LaoYang
	 * @DateTime 2017-04-14
	 * @return   [type]     [description]
	 */
	public function login(){
		//请求类型判断
		if(IS_POST){
			//接收数据
			$post = I('post.');
			//加密密码
			//$post['mg_pwd'] = getPwd($post['mg_pwd']);
			$post['mg_pwd'] = md5(md5(($post['mg_pwd'])));
			//查询用户是否存在
			$data = M('Manager') -> where($post) -> find();
			if($data){
				//存在，合法
				session('mg_id',$data['mg_id']);
				session('mg_name',$data['mg_name']);
				session('mg_time',$data['mg_time']);
				session('role_id',$data['role_id']);
				//更新本次登录时间
				M('Manager') -> where("mg_id = {$data['mg_id']}") -> save(array('mg_time' => time()));
				$this -> success('登录成功',U('Index/index'),3);
			}else{
				//非法
				$this -> error('用户名或密码错误');
			}
		}else{
			//展示模版
			$this -> display();
		}
	}

	//退出方法
	public function logout(){
		session(null);
		$this -> success('注销成功',U('login'),3);
	}

	//测试方法，获取加密密码
	// public function getMyPwd(){
	// 	echo getPwd('123456');
	// }
}