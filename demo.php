<?php 

if ($_POST['sub']) {
	//$pdo = include 'db.php';
	include 'wxchant.php';
	$wechat = new wxchant();

	$typeArr = ['image'=>1,'video'=>2,'thumb'=>3];

	$file = $_FILES['media'];
	$name = $file['name'];
	$realpath = __DIR__.'\\'.$name;
	//print_r($_FILES);die;
    //print_r($_POST);die;
	move_uploaded_file($file['tmp_name'],$realpath);
	// 上传临时素材到微信公众号
	$arr = $wechat->upload_lsc($realpath,$_POST['type'],$_POST['is_long']);
    print_r($arr);

	// 上传成功后入数据库
	//$sql = "insert into material (realpath,type,media_id,up_time,is_long,url) values (?,?,?,?,?,?)";
	//$stmt = $pdo->prepare($sql);
	//$stmt->execute([$realpath,$typeArr[$arr['type']],$arr['media_id'],$arr['created_at'],$arr['is_long'],$arr['url']]);


	//echo '上传成功';
	//exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>素材上传</title>
</head>
<body>
	<form enctype="multipart/form-data" method="post" action="" id="media" >
		<select name="type">
			<option value="image">图片</option>
			<option value="video">视频</option>
			<option value="thumb">thumb</option>
		</select>
		<select name="is_long">
			<option value="0">临时</option>
			<option value="1">永久</option>
		</select>
		<input type="file" name="media" class="form-control">				
		<input type="submit" value="上传素材" name="sub">
	</form>
	<img src="http://mmbiz.qpic.cn/mmbiz_jpg/OhryIerGym79wW0kaSENpudv0wEvaBcPnuKRYlrpofPhicZFWnDwqRibX8RlhS2RLTd8cbLwPKkxibKt4nBp05dKQ/0?wx_fmt=jpeg">
</body>
</html>