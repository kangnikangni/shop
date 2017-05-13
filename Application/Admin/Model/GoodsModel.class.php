<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-14 14:41:04
 * @Version 1.0.0
 * @Description 商品管理模型
 */
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
	//定义字段映射规则
	protected $_map = array(
			//表单中的name值 => 数据表中字段名
			'name'		=>		'goods_name',
			'price'		=>		'goods_price',
			'number'	=>		'goods_number',
			'weight'	=>		'goods_weight',
			'show'		=>		'is_show',
			'introduce'	=>		'goods_introduce'
		);

	//定义方法处理商品添加
	public function addGoods($post){
		//处理图片
		if($_FILES['goods_logo']['error'] == '0'){
			$upload = new \Think\Upload();
			//上传文件
			$info = $upload -> uploadOne($_FILES['goods_logo']);
			//保存数据
			if($info){
				$post['goods_big_logo'] = $upload -> rootPath . $info['savepath'] . $info['savename'];
				//制作缩略图
				$image = new \Think\Image();
				//打开
				$image -> open($post['goods_big_logo']);
				//制作
				$image -> thumb(160,160);
				//保存
				$image -> save($upload -> rootPath . $info['savepath'] . 'thumb_' . $info['savename']);
				//补全数据
				$post['goods_small_logo'] = $upload -> rootPath . $info['savepath'] . 'thumb_' . $info['savename'];

			}
		}
		//执行数据添加
		return $this -> add($post);
	}
}
