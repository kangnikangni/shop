<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
	//商品列表
    public function showList(){
    	//获取数据
    	$data = M('Goods') -> where("is_show = '1'") -> select();
    	//变量分配
    	$this -> assign('data',$data);
        $this -> display();
    }

    //商品详情
    public function detail(){
    	//获取id
    	$goods_id = I('get.goods_id');
    	//查询对应的商品信息
    	$info = M('Goods') -> find($goods_id);
    	//分配
    	$this -> assign('info',$info);
    	//唯一属性
    	//select t1.attr_name,t2.attr_value from sp_attribute as t1 left join sp_goodsattr as t2 on t1.attr_id = t2.attr_id where t1.attr_sel = '0' and t2.goods_id = 12;
    	$single = M('Attribute') -> field('t1.attr_name,t2.attr_value') -> alias('t1') -> join('left join sp_goodsattr as t2 on t1.attr_id = t2.attr_id') -> where("t1.attr_sel = '0' and t2.goods_id = $goods_id") -> select();
    	//dump($single);
    	$this -> assign('single',$single);
    	//选择属性
    	//select t1.attr_name,t2.attr_value from sp_attribute as t1 left join sp_goodsattr as t2 on t1.attr_id = t2.attr_id where t1.attr_sel = '1' and t2.goods_id = 12;
    	$multi = M('Attribute') -> field('t1.attr_name,t2.attr_value') -> alias('t1') -> join('left join sp_goodsattr as t2 on t1.attr_id = t2.attr_id') -> where("t1.attr_sel = '1' and t2.goods_id = $goods_id") -> select();
    	foreach ($multi as $key => $value) {
    		$multi[$key]['attr_value'] = explode(',', $value['attr_value']);
    	}
    	//dump($multi);die;
    	$this -> assign('multi',$multi);
    	//获取相册信息
    	$pics = M('Goodspics') -> where("goods_id = $goods_id") -> select();
    	//dump($pics);die;
    	$this -> assign('pics',$pics);
        $this -> display();
    }
}