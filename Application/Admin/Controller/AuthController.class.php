<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-17 16:11:17
 * @Version 1.0.0
 * @Description 权限管理控制器
 */
namespace Admin\Controller;
class AuthController extends CommonController{

	//权限列表
	public function showList(){
		//获取数据
		$data = M('Auth') -> select();
		//实现无限级分类效果
		load('@/tree');
		$data = getTree($data);
		//变量分配
		$this -> assign('data',$data);
		//展示模版
		$this -> display();
	}

	//添加权限
	public function add(){
		//请求类型判断
		if(IS_POST){
			//提交
			$post = I('post.');
			//写入数据
			if(M('Auth') -> add($post)){
				//成功
				$this -> success('权限添加成功',U('showList'),3);
			}else{
				//失败
				$this -> error('权限添加失败');
			}
		}else{
			//查询父级权限
			$parent = M('Auth') -> where("auth_pid = 0") -> select();
			//变量分配
			$this -> assign('parent',$parent);
			//展示模版
			$this -> display();
		}
	}
}
