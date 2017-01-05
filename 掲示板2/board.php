<?php
require_once 'DbManager.php';
require_once 'MyValidator.php';

session_start();

if (!isset($_SESSION["NAME"])) {
	header("Location: Logout.php");
	exit;
}

if(isset($_POST['toukou'])){

	$v = new MyValidator();
	$v->requiredCheck($_POST['contents'], 'メッセージ');
	$v->lengthCheck($_POST['contents'], 'メッセージ', 50);

	$contents = htmlspecialchars($_POST['contents']);
	
	try {
	$db = getDb();
	
	$stt = $db->prepare('INSERT INTO post(contents, user_id) VALUES(:contents, :user_id )');
		

	$stt->bindParam(':contents', $_POST['contents']);
	$stt->bindParam(':user_id', $_SESSION["USERID"]);
	$stt->execute();
	$db = NULL;
	
	} catch(PDOException $e) {
	die("エラーメッセージ:{$e->getMessage()}");
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>簡易掲示板</title>
</head>
<body>
	<h1>簡易掲示板</h1></br>
	
	<a href="Logout.php">ログアウト</a> <a href="delete.php">削除</a> <a href="edit.php">編集</a>
	
	<p>ようこそ<u><?php echo htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?></u><u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>
	<p>メッセージは50文字以内で入力してください</p>

	<form action="" method="POST">

	メッセージ:<input type="text" name="contents" autocomplete="off">

	<input type="submit" name='toukou'　value="投稿"></br></br>
	

	</form>

<?php
try{
	$db = getDb();
	$stt = $db->query('SELECT * FROM post ORDER BY id DESC');
	$stt->execute();
	$post_list = $stt->fetchAll();
	foreach ($post_list as $row){
			echo $row["id"]." ".$row["contents"]." ".$row["user_id"];
			echo '<br>';}
	$db = null;
	}catch(PDOException $e) {
		die("エラーメッセージ:{$e->getMessage()}");
}
	
		
	
?>

</body>
</html>