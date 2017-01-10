<?php


function getDb() {
	$dsn = 'mysql:dbname=bulletin; host=127.0.0.1';
	$usr = 'root';
	$passwd = '';

	try {
	//データベースの接続を確立
	$db = new PDO($dsn, $usr, $passwd);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//データベース接続時に使用する文字コードをutf8に設定
	$db->exec('SET NAMES utf8');
	} catch (PDOException $e) {
	die("接続エラー:{$e->getMessage()}");
	}
	return $db;
}


require_once('../libs/Smarty.class.php');
$smartyObj=new Smarty();
$smartyObj->template_dir='../templates/';
$smartyObj->compile_dir='../templates_c/';

?>