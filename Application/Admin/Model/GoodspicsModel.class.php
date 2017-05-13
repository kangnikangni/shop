<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-16 16:02:58
 * @Version 1.0.0
 * @Description 商品相册管理模型
 */
namespace Admin\Model;
use Think\Model;
class GoodspicsModel extends Model{

	//保存相册图片
	public function savePics($goods_id){
		//处理图片
		$flag = false;
		foreach ($_FILES['goods_pic']['error'] as $key => $value) {
			//至少要求有一个value【error】为0
			if($value == '0'){
				$flag = true;
				break;
			}
		}
		//如果标记为真
		if($flag){
			//正式的处理图片
			$upload = new \Think\Upload();
			//开始上传
			$info = $upload -> upload();
			//判断
			if($info){
				//开始处理图片
				$data = array();
				//循环生成
				//实例化图形处理类
				$image = new \Think\Image();
				foreach ($info as $key => $value) {
					//原图
					$data[$key]['pics_ori'] = $upload -> rootPath . $value['savepath'] . $value['savename'];
					$data[$key]['goods_id'] = $goods_id;
					//打开图片
					$image -> open($data[$key]['pics_ori']);
					//制作缩略图
					$image -> thumb(800,800);	//大图800,800
					$bigUrl = $upload -> rootPath . $value['savepath'] . 'big_' . $value['savename'];
					$image -> save($bigUrl);

					$image -> thumb(350,350);	//中图350,350
					$midUrl = $upload -> rootPath . $value['savepath'] . 'mid_' . $value['savename'];
					$image -> save($midUrl);

					$image -> thumb(50,50);		//小图50,50
					$smaUrl = $upload -> rootPath . $value['savepath'] . 'sma_' . $value['savename'];
					$image -> save($smaUrl);
					//补充数据
					$data[$key]['pics_big'] = $bigUrl;
					$data[$key]['pics_mid'] = $midUrl;
					$data[$key]['pics_sma'] = $smaUrl;
				}
			}
		}
		//保存数据
		return $this -> addAll($data);
	}
}
