<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-14 11:25:38
 * @Version 1.0.0
 * @Description 商品管理控制器
 */

namespace Admin\Controller;
class GoodsController extends CommonController{
	//商品添加
	public function add(){
		//判断当前的请求类型
		if(IS_POST){
			dump($_POST);
			//提交数据
			$post = D('Goods') -> create();
			//特殊处理商品介绍
			dump($post);die;
			$post['goods_introduce'] = filterXSS($_POST['introduce']);
			//补全数据
			$post['upd_time'] = $post['add_time'] = $post['sale_time'] = time();
			//保存数据
			//dump($_POST['attr_vals']);die;
			if($goods_id = D('Goods') -> addGoods($post)){
				//组装属性数据
				$data = array(
							'goods_id'		=>		$goods_id,
						);
				foreach ($_POST['attr_vals'] as $key => $value) {
					#key表示属性表的主键id，value表示属性值/多个值
					$data['attr_id'] = $key;
					$data['attr_value']	= implode(',', $value);
					//保存到数据表
					M('Goodsattr') -> add($data);
				}
				//表示成功
				$this -> success('商品添加成功',U('showList'),3);
			}else{
				$this -> error('商品添加失败');
			}
		}else{
			//获取商品类型
			$type = M('Type') -> select();
			//变量分配
			$this -> assign('type',$type);
			$this -> display();
		}
	}

	//商品列表
	public function showList(){
		//查询数据
		$data = M('Goods') -> select();
		//变量分配
		$this -> assign('data',$data);
		$this -> display();
	}

	// public function add(){
	// 	//判断当前的请求类型
	// 	if(IS_POST){
	// 		//提交数据
	// 		//$post = D('Goods') -> create();
	// 		$post['goods_name'] = $_POST['name'];
	// 		$post['goods_price'] = $_POST['price'];
	// 		$post['goods_number'] = $_POST['number'];
	// 		$post['goods_weight'] = $_POST['weight'];
	// 		$post['is_show'] = $_POST['show'];
	// 		$post['goods_introduce'] = $_POST['introduce'];
	// 		//补全数据
	// 		$post['upd_time'] = $post['add_time'] = $post['sale_time'] = time();
	// 		//dump($post);die;
	// 		//保存数据
	// 		if(D('Goods') -> add($post)){
	// 			//表示成功
	// 			$this -> success('商品添加成功',U('showList'),3);
	// 		}else{
	// 			$this -> error('商品添加失败');
	// 		}
	// 	}else{
	// 		$this -> display();
	// 	}
	// }
	
	//商品相册
	public function photos(){
		//判断请求类型
		$goods_id = I('get.goods_id');
		if(IS_POST){
			//处理提交
			if(D('Goodspics') -> savePics($goods_id)){
				//成功
				$this -> success('相册图片添加成功',U('photos',array('goods_id' => $goods_id)),3);
			}else{
				$this -> error('相册图片添加失败');
			}
		}else{
			$data = M('Goodspics') -> where("goods_id = $goods_id") -> select();
			$this -> assign('data',$data);
			$this -> display();
		}
	}

	//删除图片
	public function delpic(){
		//接收id
		$pic_id = I('get.pic_id');
		//删除磁盘上的文件
		$info = M('Goodspics') -> find($pic_id);
		unlink($info['pics_ori']);
		unlink($info['pics_big']);
		unlink($info['pics_mid']);
		unlink($info['pics_sma']);
		//删除记录
		$result = M('Goodspics') -> delete($pic_id);	//如果成功则是1，否则返回false
		echo $result;
	}

	//返回商品类型对应的属性
	public function getAttr(){
		//请求类型判断
		if(IS_AJAX){
			//获取商品类型id
			$type_id = I('post.type_id');
			//查询该类型对应的全部商品属性
			$data = M('Attribute') -> where("type_id = $type_id") -> select();
			//json格式输出
			echo json_encode($data);//php自带的方法
			//$this -> ajaxReturn($data);//ThinkPHP封装的返回方案
		}else{
			echo '非正常访问';
		}
	}
}