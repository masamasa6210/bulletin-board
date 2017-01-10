<?php
require ('Smarty.php');
require ('password.php');// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once ('MyValidator_Smarty.php');


$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bulletin";  // データベース名

$errorMessage = "";

if(isset($_POST["login"])){
	if(empty($_POST["userid"])){
		$errorMessage = "ユーザーIDが未入力です。";
	} else if(empty($_POST["password"])){
		$errorMessage = "パスワードが未入力です";
	}

	$v = new MyValidator();
	$v->intTypeCheck($_POST['userid'], 'ユーザーID');
	$v->altumTypeCheck($_POST['password'], 'パスワード');
	$v->regexCheck($_POST['password'], 'パスワード');

	if(!empty($_POST["userid"]) && !empty($_POST["password"])) {
		$userid = $_POST["userid"];
		$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

		try{
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

			$stmt = $pdo->prepare('SELECT * FROM member WHERE id = ?');
			$stmt->execute(array($userid));

			$password = $_POST["password"];

			if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				if(password_verify($password, $row['password'])) {
					session_regenerate_id(true);

					$sql = "SELECT * FROM member WHERE id = $userid";
					$stmt = $pdo->query($sql);
					foreach ($stmt as $row) {
						$row['id'];
						$row['name'];
					}
					$_SESSION["USERID"] = $row['id'];
					$_SESSION["NAME"] = $row['name'];
					header("Location: board_Smarty.php");
					exit;
				}else{
					$errorMessage = "ユーザーIDあるいはパスワードに誤りがあります。";
				}
			}

				} catch(PDOException $e) {
					die("エラーメッセージ:{$e->getMessage()}");
				
			}
		}
	}
$smartyObj->assign('errors', $errorMessage);
$smartyObj->display('Login_Smarty.tpl');
?>

