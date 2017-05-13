<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-18 11:29:51
 * @Version 1.0.0
 * @Description 商品类型管理控制器
 */

namespace Admin\Controller;
class TypeController extends CommonController{

	//添加类型
	public function add(){
		if(IS_POST){
			$post = I('post.');
			//写入到数据表
			if(M('Type') -> add($post)){
				$this -> success('商品类型添加成功',U('showList'),3);
			}else{
				$this -> error('商品类型添加失败');
			}
		}else{
			$this -> display();
		}
	}

	//类型的展示
	public function showList(){
		//获取
		$data = M('Type') -> select();
		$this -> assign('data',$data);
		$this -> display();
	}
}
