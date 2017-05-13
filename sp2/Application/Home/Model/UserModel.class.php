<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-21 16:02:00
 * @Version 1.0.0
 * @Description 前台用户管理模型
 */

namespace Home\Model;
use Think\Model;
class UserModel extends Model{

	//自定义验证的规则
	protected $_validate	=	array(
			//array(验证字段,验证规则,错误提示[,验证条件,附加规则,验证时间]);
			//针对用户名的验证，不能重复
			array('user_name','require','用户名不能为空'),
			array('user_name','','用户名已经存在',0,'unique'),
			//针对密码的验证：不能为空，两次密码一样
			array('user_pwd','require','用户密码不能为空'),
			array('user_pwd1','user_pwd','两次输入的密码不一致',0,'confirm')
			//...
		);
}
