<?php

require 'password.php';// password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require_once 'MyValidator.php';

session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "root";  // ユーザー名
$db['pass'] = "";  // ユーザー名のパスワード
$db['dbname'] = "bulletin";  // データベース名

$error_message = "";

if(isset($_POST["edit"])){
	if(empty($_POST["id"])){
		$error_message = "投稿IDが未入力です。";
	} else if(empty($_POST["contents"])){
		$error_message = "メッセージが未入力です";
	} else if(empty($_POST["password"])){
		$error_message = "パスワードが未入力です";
	}

	$v = new MyValidator();
	$v->intTypeCheck($_POST['id'], '投稿ID');
	$v->altumTypeCheck($_POST['password'], 'パスワード');
	$v->regexCheck($_POST['password'], 'パスワード');
	$v->lengthCheck($_POST['contents'], 'メッセージ', 50);
	
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

			$stmt = $pdo->prepare('SELECT * FROM member WHERE id = ?');
			$stmt->execute(array($row['user_id']));
			
			$password = $_POST["password"];

			if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				if(password_verify($password, $row['password'])) {
					
					$contents=trim($_POST['contents']);
					$updateSql=$pdo->prepare('update post set contents=:contents where id=:id');
					$updateSql->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
					$updateSql->bindValue(':contents', $contents, PDO::PARAM_STR);
					$updateSql->execute();
					echo "編集に成功しました";
					
				}else{
					$error_message = "投稿IDあるいはパスワードに誤りがあります。";
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
<title>編集画面</title>
</head>
<body>


<h2>編集画面</h2>
		<form id="deleteform" name = "deleteform" action="" method="POST">
			<fieldset>
				<legend>編集フォーム</legend>
				<div><font color="#ff0000"><?php echo $error_message ?></font></div>
				<div>投稿IDとメッセージとユーザーIDのパスワードを入力すると自分の投稿のみ編集できます。</div>
				<label for="id">投稿ID</label>
				<input type="text" id="id" name="id" placeholder="投稿IDを入力" value="<?php if (!empty($_POST["id"])) {echo htmlspecialchars($_POST["id"], ENT_QUOTES);} ?>" autocomplete="off">
				<br>
				<label for="contents">メッセージ</label>
				<input type="text" id="contents" name="contents" placeholder="メッセージを入力" value="<?php if (!empty($_POST["contents"])) {echo htmlspecialchars($_POST["contents"], ENT_QUOTES);} ?>" autocomplete="off">
				<br>
				<label for="password">パスワード</label>
				<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
				<br>
				<input type="submit" id="edit" name="edit" value="編集">
			</fieldset>
		</form>
		<form action="board.php">
			<fieldset>
				<legend>掲示板へ戻る</legend>
				<input type="submit" value="掲示板へ">
			</fieldset>
		</form>
</body>
</html>