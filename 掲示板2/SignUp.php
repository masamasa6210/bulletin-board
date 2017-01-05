<?php
require 'password.php';// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once 'MyValidator.php';

session_start();

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
		// var_dump($dsn);
		try {
			$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$stmt = $pdo->prepare("INSERT INTO member(name, password) VALUES(?, ?)");
				
			$stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));
			$userid = $pdo->lastinsertid();

			 $SignUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
        	} catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
			}
	}else if($_POST["password"] != $_POST["password2"]) {
		$errorMessage = 'パスワードに誤りがあります。';
	}
}
?>
<!doctype html>
<html>
<body>
<h2>新規登録画面</h2>
	<form id = "loginForm" name = "loginForm" action = "" method="post">
		<fieldset>
					<legend>新規登録フォーム</legend>
					<div><font color="#ff0000"><?php echo $errorMessage ?></font></div>
					<div><font color="#0000ff"><?php echo $SignUpMessage ?></font></div>
					<div><font color="#0000ff">ユーザー名は20文字以内、パスワードは英数字で4文字以上8文字以内で入力してください。</font></div>
					<label for="username">ユーザー名</label>
					<input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>" autocomplete="off">
					<br>
					<label for="password">パスワード</label>
					<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
					<br>
					<label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力" autocomplete="off">
					<br>
					<input type="submit" id="signUp" name="signUp" value="新規登録">
		</fieldset>
	</form>
	<form action="Login.php">
			<fieldset>
				<legend>	ログインフォーム</legend>
				<input type="submit" value="ログイン画面へ">
			</fieldset>
		</form>
</body>
</html>