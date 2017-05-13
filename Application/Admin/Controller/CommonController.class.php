<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-18 09:32:25
 * @Version 1.0.0
 * @Description 基础控制器
 */

namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{

	//构造方法
	public function __construct(){
		//构造父类的构造函数
		parent::__construct();
		//判断用户是否登录
		if(!session('?mg_id')){
			//表示没有登录
			//$this -> error('请先登录...',U('Public/login'),3);exit;
			//需要通过JavaScript代码实现
			$url = U('Public/login');
			echo "<script>top.location.href='$url';</script>";exit;
		}
		//特殊用户判断
		if(session('role_id') > '1'){
			//走到这里说明已经登录
			$controller = CONTROLLER_NAME;	//获取当前控制器名
			$action = ACTION_NAME;	//当前操作方法名称
			$ac = strtolower($controller . '-' . $action);
			//获取对应的权限列表
			$acs = M('Role') -> find(session('role_id'));
			$hasAuth = strtolower($acs['role_auth_ac']) . ',index-index,index-left,index-top,index-main';
			//权限判断
			if(strpos($hasAuth,$ac) === false){
				$this -> error('sorry您没有权限访问...',U('Index/index'),3);exit;
			}
		}
	}

	//ThinkPHP封装的初始化函数
	// public function _initialize(){

	// }
}