<?php

require 'password.php';// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once 'MyValidator.php';

session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bulletin";  // データベース名

$error_message = "";

if(isset($_POST["login"])){
	if(empty($_POST["userid"])){
		$error_message = "ユーザーIDが未入力です。";
	} else if(empty($_POST["password"])){
		$error_message = "パスワードが未入力です";
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
					header("Location: board.php");
					exit;
				}else{
					$error_message = "ユーザーIDあるいはパスワードに誤りがあります。";
				}
			}

				} catch(PDOException $e) {
					die("エラーメッセージ:{$e->getMessage()}");
				
			}
		}
	}

?>

<!doctype html>
<html>
<head>
<title>ログイン画面</title>
</head>
<body>


<h1>ようこそ！掲示板へ！</h1>
		<form id="loginForm" name = "loginForm" action="" method="POST">
			<fieldset>
				<legend>ログインフォーム</legend>
				<div><font color="#ff0000"><?php echo $error_message ?></font></div>
				<label for="userid">ユーザーID</label>
				<input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>" autocomplete="off">
				<br>
				<label for="password">パスワード</label>
				<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
				<br>
				<input type="submit" id="login" name="login" value="ログイン">
			</fieldset>
		</form>
		<br>
		<form action="SignUp.php">
			<fieldset>
				<legend>新規登録フォーム</legend>
				<input type="submit" value="新規登録">
			</fieldset>
		</form>
</body>
</html>