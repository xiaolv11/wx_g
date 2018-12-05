<?php

// 数据库操作
$dsn = 'mysql:host=localhost;dbname=weixin67;charset=utf8mb4';
$username = 'root';
$password = 'root';

try {
	$pdo = new PDO($dsn,$username,$password,[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	]);
	return $pdo;
} catch (PDOException $e) {
	
}

