<?php
require ('Smarty.php');
require ('password.php');// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once ('MyValidator_Smarty.php');


$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bulletin";  // データベース名

$errorMessage = "";

if (isset($_SESSION["USERID"])) {
	if(isset($_POST["delete"])){
		if(empty($_POST["id"])){
			$errorMessage = "投稿IDが未入力です。";
		} else if(empty($_POST["password"])){
			$errorMessage = "パスワードが未入力です";
		}

		$v = new MyValidator();
		$v->intTypeCheck($_POST['id'], '投稿ID');
		$v->altumTypeCheck($_POST['password'], 'パスワード');
		$v->regexCheck($_POST['password'], 'パスワード');

		if(!empty($_POST["id"]) && !empty($_POST["password"])) {
			$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

			try{
				$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

				$stmt = $pdo->prepare('SELECT user_id FROM post WHERE id = :id');
				$stmt->bindParam(':id', $_POST["id"]);
				$stmt->execute();

				foreach ($stmt as $row) {
				$row['user_id'];
				}

				$stmt = $pdo->prepare('SELECT * FROM member WHERE id = :id');
				$stmt->bindParam(':id', $row['user_id']);
				$stmt->execute();

				$password = $_POST["password"];

				if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					if(password_verify($password, $row['password']) && $_SESSION["NAME"] == $row['name']) {
						$deleteSql=$pdo->prepare('delete from post where id=:id');
						$deleteSql->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
						$deleteSql->execute();
						echo "削除に成功しました";
					}else{
						$errorMessage = "投稿IDあるいはパスワードに誤りがあります。";
					}
				}

				} catch(PDOException $e) {
					die("エラーメッセージ:{$e->getMessage()}");
				}
			}
		}
	}else{
		header("Location: Logout_Smarty.php");
}

$smartyObj->assign('errors', $errorMessage);
$smartyObj->display('delete_Smarty.tpl');
