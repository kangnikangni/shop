<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-18 14:43:48
 * @Version 1.0.0
 * @Description 属性管理控制器
 */

namespace Admin\Controller;
class AttributeController extends CommonController{

	//添加属性
	public function add(){
		//判定请求类型
		if(IS_POST){
			//处理提交
			$data = M('Attribute') -> create();	//默认接收post
			//针对多选的属性进行逗号处理
			$data['attr_vals'] = str_replace('，', ',', $data['attr_vals']);
			//写入判断
			if(M('Attribute') -> add($data)){
				$this -> success('属性添加成功',U('showList'),3);
			}else{
				$this -> error('属性添加失败');
			}
		}else{
			//获取商品类型
			$type = M('Type') -> select();
			//变量分配
			$this -> assign('type',$type);
			//展示模版
			$this -> display();
		}
	}

	//展示属性列表
	public function showList(){
		//select t1.*,t2.type_name from sp_attribute as t1 left join sp_type as t2 on t1.type_id = t2.type_id;
		$data = M('Attribute') -> field('t1.*,t2.type_name') -> alias('t1') -> join('left join sp_type as t2 on t1.type_id = t2.type_id') -> select();
		//变量分配
		$this -> assign('data',$data);
		$this -> display();
	}
}