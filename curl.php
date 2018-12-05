<?php

/*$file = __DIR__.'/10.jpg';

var_dump(httpPostFile('http://localhost:8080/demo.php',['username'=>'admin','password'=>'admin888'],$file));*/

/**
 * curl发送GET请求
 * @param  string $url [description]
 * @return [type]      [description]
 */
function httpGet(string $url){
	// 启动curl
	$ch = curl_init();
	// 设置请求URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	// 不获取header头信息
	curl_setopt($ch,CURLOPT_HEADER,0);
	// 结果不直接返回到终端
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// 设置curl不进行证书的检测
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

	// 超时时间 秒
	curl_setopt($ch,CURLOPT_TIMEOUT,10);
	// 设置请求的浏览器
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);

	// 获取错误码
	$errorno = curl_errno($ch);

	// 0如果没有错误发生
	if ($errorno > 0) {
		$errorstr = curl_error($ch);
	}

	// 关闭curl资源
	curl_close($ch);

	if ($info['http_code'] == '200') {
		return $data;
	}
	#echo $errorstr;
	return false;
}


/**
 * curl发送post请求
 * @param  string $url  [description]
 * @param  array  $post [description]
 * @return [type]       [description]
 */
function httpPost(string $url,array $post){
	// 启动curl
	$ch = curl_init();
	// 设置请求URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	// 不获取header头信息
	curl_setopt($ch,CURLOPT_HEADER,0);
	// 结果不直接返回到终端
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// 设置curl不进行证书的检测
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

	// 超时时间 秒
	curl_setopt($ch,CURLOPT_TIMEOUT,10);
	// 设置请求的浏览器
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
	// 发起POST请求
	curl_setopt($ch,CURLOPT_POST,1);
	// post发送的数据
	// POST提交的数据的格式如下 key1=value1&key2=value2
	curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post));

	$data = curl_exec($ch);
	$info = curl_getinfo($ch);

	// 获取错误码
	$errorno = curl_errno($ch);

	// 0如果没有错误发生
	if ($errorno > 0) {
		$errorstr = curl_error($ch);
	}

	// 关闭curl资源
	curl_close($ch);

	if ($info['http_code'] == '200') {
		return $data;
	}
	#echo $errorstr;
	return false;
}



/**
 * curl发送post请求
 * @param  string $url  [description]
 * @param  array  $post [description]
 * @param  string  $file [description]
 * @return [type]       [description]
 */
function httpPostFile(string $url,array $post,string $file){
	// php5.5之后的写法，也是推存的写法
	$post['pic'] = new CURLFile($file);
	// 启动curl
	$ch = curl_init();
	// 设置请求URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	// 不获取header头信息
	curl_setopt($ch,CURLOPT_HEADER,0);
	// 结果不直接返回到终端
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// 设置curl不进行证书的检测
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

	// 超时时间 秒
	curl_setopt($ch,CURLOPT_TIMEOUT,10);
	// 设置请求的浏览器
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
	// 发起POST请求
	curl_setopt($ch,CURLOPT_POST,1);
	// post发送的数据
	// POST提交的数据的格式如下 key1=value1&key2=value2 
	// 如果是数组则可以上传文件，序列化后则不可以上传文件
	curl_setopt($ch,CURLOPT_POSTFIELDS,$post);

	$data = curl_exec($ch);
	$info = curl_getinfo($ch);

	// 获取错误码
	$errorno = curl_errno($ch);

	// 0如果没有错误发生
	if ($errorno > 0) {
		$errorstr = curl_error($ch);
	}

	// 关闭curl资源
	curl_close($ch);

	if ($info['http_code'] == '200') {
		return $data;
	}
	#echo $errorstr;
	return false;
}


/**
 * curl发送post请求
 * @param  string $url  [description]
 * @param  array|json  $post [description]
 * @param  string  $file [description]
 * @return [type]       [description]
 */
function request(string $url,$post,string $file = ''){
	// 文件上传
	if ($file != '') {
		// php5.5之后的写法，也是推存的写法
		$post['pic'] = new CURLFile($file);
	}
	// 启动curl
	$ch = curl_init();
	// 设置请求URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	// 不获取header头信息
	curl_setopt($ch,CURLOPT_HEADER,0);
	// 结果不直接返回到终端
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// 设置curl不进行证书的检测
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

	// 超时时间 秒
	curl_setopt($ch,CURLOPT_TIMEOUT,10);
	// 设置请求的浏览器
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');

	// post提交
	if (!empty($post)) {
		// 发起POST请求
		curl_setopt($ch,CURLOPT_POST,1);
		// post发送的数据
		// POST提交的数据的格式如下 key1=value1&key2=value2 
		// 如果是数组则可以上传文件，序列化后则不可以上传文件
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
	}
	
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);

	// 获取错误码
	$errorno = curl_errno($ch);

	// 0如果没有错误发生
	if ($errorno > 0) {
		$errorstr = curl_error($ch);
	}
	// 关闭curl资源
	curl_close($ch);

	if ($info['http_code'] == '200') {
		return $data;
	}
	#echo $errorstr;
	return false;
}