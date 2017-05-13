<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-17 11:39:13
 * @Version 1.0.0
 * @Description 角色管理控制器
 */

namespace Admin\Controller;
class RoleController extends CommonController{

	//角色信息展示
	public function showList(){
		//获取数据
		$data = M('Role') -> select();
		//变量分配
		$this -> assign('data',$data);
		//展示模版
		$this -> display();
	}

	//分派权限
	public function setAuth(){
		//请求类型判断
		if(IS_POST){
			$role_id = I('get.role_id');
			$post = I('post.');
			$result = D('Role') -> saveRoleAuth($role_id,$post);
			//判断跟新结果
			if($result){
				//成功
				$this -> success('分派权限成功',U('showList'),3);
			}else{
				//失败
				$this -> error('分派权限失败');
			}
		}else{
			//获取全部的权限信息
			$top  = M('Auth') -> where("auth_pid = 0") -> select();
			$cate = M('Auth') -> where("auth_pid != 0") -> select();
			$this -> assign('top',$top);
			$this -> assign('cate',$cate);
			//通过角色id查询角色信息
			$role_id = I('get.role_id');
			$role = M('Role') -> find($role_id);
			//变量分配
			$this -> assign('role',$role);
			//展示模版
			$this -> display();
		}
	}
}