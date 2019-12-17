<?php 

	//创建redis对象
	$redis = new Redis;

	//连接redis服务器
	$redis->connect('redis', 6379);

	//输入密码
	$redis->auth(123456);

	//写入数据
	$res = $redis->set('name','anan');

	var_dump($res);

 ?>