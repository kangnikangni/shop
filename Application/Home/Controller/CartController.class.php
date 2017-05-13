<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-22 10:28:46
 * @Version 1.0.0
 * @Description 购物车控制器
 */

namespace Home\Controller;
use Think\Controller;
//引入需要使用的购物车类
use Tools\Cart;
class CartController extends Controller{

	public function test(){
		$cart = new Cart();
		dump($cart);
	}

	//商品添加购物车操作
	public function add(){
		//接收数据
		$get = I('get.');	//包含了goods_id和amount
		//根据函数的要求准备数据
		//array('goods_id'=>'10','goods_name'=>'诺基亚','goods_price'=>'1750','goods_buy_number'=>'1','goods_total_price'=>1750);
		$info = M('Goods') -> find($get['goods_id']);	//商品信息
		//组合数据
		$data = array(
				'goods_id'		=>	$get['goods_id'],
				'goods_name'		=>	$info['goods_name'],
				'goods_price'		=>	$info['goods_price'] * 0.1,
				'goods_buy_number'	=>	$get['amount'],
				'goods_total_price'	=>	$info['goods_price'] * 0.1 * $get['amount']			//商品总价 = 商品数量 × 商品单价
			);
                //dump($data);die;
		//保存数据
		$cart = new Cart();
		$cart -> add($data);
		//获取总的价格数量
		$total = $cart -> getNumberPrice();
		echo json_encode($total);
	}

	//购物车商品的查看功能  
	public function flow1(){
		//获取购车的数据
		$cart = new Cart();
		$cartInfo = $cart -> getCartInfo();	//获取购物车的数据
		//dump($cartInfo);
		$keys = implode(',',array_keys($cartInfo));
                dump(array_keys($cartInfo));
                setcookie(cart,'');die;
		//判断是否有数据
		if($keys){
			//获取图片数据
			//$thumbs = M('Goods') -> field('goods_id,goods_small_logo') -> where("goods_id in ($keys)") -> select();
			//dump($keys);die;
                    //dump($_COOKIE);die;
			$thumbs = M('Goods') -> where("goods_id in ($keys)") -> getField('goods_id,goods_small_logo');
			//组合两部分的数据
			foreach ($cartInfo as $key => $value) {
				#key是商品id 
				$cartInfo[$key]['thumb'] = ltrim($thumbs[$key],'.');
			}
			//变量分配
			$this -> assign('cartInfo',$cartInfo);
			//获取总的价格数量
			$total = $cart -> getNumberPrice();
			$this -> assign('totalprice',$total['price']);
		}
		$this -> display();
	}

	//购物车商品删除的方法
	public function del(){
		//接收商品id
		$goods_id = I('post.goods_id');
		//删除
		$cart = new Cart();
		$cart  -> del($goods_id);
		//判断是否成功，依据id是否还在数据里面
		if(array_key_exists($goods_id, $cart -> getCartInfo())){
			//删除失败
			$data['code'] = '0';
		}else{
			//删除成功
			$data['code'] = '1';
			//重新获取总价
			$total = $cart -> getNumberPrice();
			$data['total'] = $total['price'];
		}
		//输出结果
		echo json_encode($data);
	}

	//更改商品的数量
	public function edit(){
		//获取数据
		$post = I('post.');	//goods_id  amount
		//实例化
		$cart = new Cart();
		$xiaoji = $cart -> changeNumber($post['amount'],$post['goods_id']);
		//总价
		$total = $cart -> getNumberPrice();
		$data['total'] = $total['price'];
		$data['xiaoji'] = $xiaoji;
		//输出
		echo json_encode($data);
	}

	//订单确认页面
	public function flow2(){
		//判断是否登录
		if(!session('?user_id')){
			//提示用户去登录
			$this -> error('请先登录',U('User/login',array('tc' => 'Cart','ta' => 'flow2')),3);exit;
		}
		//获取数据
		$cart = new Cart();
		$cartInfo = $cart -> getCartInfo();	//整个购物车的信息
		//获取全部键值的组合
		$keys = implode(',', array_keys($cartInfo));	//字符串
		//判断是否有值
		if($keys){
			//查询图片
			$thumbs = M('Goods') -> where("goods_id in ($keys)") -> getField('goods_id,goods_small_logo');
			//组合数据
			foreach ($cartInfo as $key => $value) {
				#key表示商品id
				$cartInfo[$key]['thumb'] = ltrim($thumbs[$key],'.');
			}
			//获取商品的汇总信息
			$total = $cart -> getNumberPrice();
			//分配
			$this -> assign('cartInfo',$cartInfo);
			$this -> assign('total',$total);
		}
		//展示模版
		$this -> display();
	}
}