<?php
return array(
	//'配置项'=>'配置值'
	//特殊字符串的定义
	'TMPL_PARSE_STRING'		=>		array(
			'__ADMIN__'	=>	'/Public/Admin',
			'__HOME__'	=>	'/Public/Home'
		),

	/* 数据库设置 */
	//oracle mssql sqlite access postgresql mariadb
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'shop_hm03',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
);