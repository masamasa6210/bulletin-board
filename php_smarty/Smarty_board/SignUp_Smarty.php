<?php
require ('Smarty.php');
require_once ('password.php');// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once ('MyValidator_Smarty.php');


$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bulletin";  // データベース名

$errorMessage = "";
$SignUpMessage = "";


if (isset($_POST["signUp"])) {

	if (empty($_POST["username"])) {  // 値が空のとき
		$errorMessage = '名前が未入力です。';

	} else if (empty($_POST["password"])) {
		$errorMessage = 'パスワードが未入力です。';

	}

	$v = new MyValidator();
	$v->lengthCheck($_POST['username'], 'ユーザー名', 20);
	$v->altumTypeCheck($_POST['password'], 'パスワード');
	$v->regexCheck($_POST['password'], 'パスワード');
	$v->altumTypeCheck($_POST['password2'], 'パスワード');
	$v->regexCheck($_POST['password2'], 'パスワード');

	if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] == $_POST["password2"]) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		// //  ユーザIDとパスワードが入力されていたら認証する
		$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
		
		try {
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$stmt = $pdo->prepare("INSERT INTO member(name, password) VALUES(:name, :password)");
			$stmt->bindParam(':name', $username);
			$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
			$stmt->execute();
			$userid = $pdo->lastinsertid();

			 $SignUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
			} catch (PDOException $e) {
				$errorMessage = 'データベースエラー';
			}
	}else if($_POST["password"] != $_POST["password2"]) {
		$errorMessage = 'パスワードに誤りがあります。';
	}
}
$smartyObj->assign('errors', $errorMessage);
$smartyObj->assign('signup', $SignUpMessage);
$smartyObj->display('SignUp_Smarty.tpl');
?>
