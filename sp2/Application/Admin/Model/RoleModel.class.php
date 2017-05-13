<?php
/**
 * @Author 黑马程序员-传智播客旗下高端教育品牌 [itcast.cn]
 * @Date    2017-04-17 15:51:41
 * @Version 1.0.0
 * @Description 角色模型
 */

namespace Admin\Model;
use Think\Model;
class RoleModel extends Model{

	//分派权限
	public function saveRoleAuth($role_id,$post){
		//定义空数组
		$data = array();
		//处理数据
		$data['role_id'] = $role_id;
		$data['role_auth_ids'] = implode(',', $post['auth_id']);
		$str = '';
		//查询全部的权限信息
		$auth = M('Auth') -> where("auth_pid > 0 and auth_id in ({$data['role_auth_ids']})") -> select();
		//循环遍历拼凑自字符串
		foreach ($auth as $key => $value) {
			//链接字符串
			$str .= $value['auth_c'] . '-' . $value['auth_a'] . ',';
		}
		//去除末尾的多余逗号
		$data['role_auth_ac'] = rtrim($str,',');
		//执行保存
		return $this -> save($data);
	}
}