<?php
require_once 'DbManager.php';
require_once 'MyValidator.php';

date_default_timezone_set('Asia/Tokyo');


if(isset($_POST['toukou'])){

	$v = new MyValidator();
	$v->requiredCheck($_POST['name'], '名前');
	$v->requiredCheck($_POST['contents'], 'メッセージ');
	$v->lengthCheck($_POST['name'], '名前', 20);
	$v->lengthCheck($_POST['contents'], 'メッセージ', 50);

	$name = htmlspecialchars($_POST['name']);
	$contents = htmlspecialchars($_POST['contents']);
	}

	try {
	$db = getDb();
	
	$stt = $db->prepare('INSERT INTO post(name, contents) VALUES(:name, :contents)');
		
	$stt->bindParam(':name', $_POST['name']);
	$stt->bindParam(':contents', $_POST['contents']);
	$stt->execute();
	$db = NULL;
	
	} catch(PDOException $e) {
	die("エラーメッセージ:{$e->getMessage()}");
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
	<p>名前は20文字以内、メッセージは50文字以内で入力してください</p>

	<form action="" method="POST">

	名前:<input type="text" name="name">
	メッセージ:<input type="text" name="contents">

	<input type="submit" name='toukou'　value="投稿"></br></br>

	</form>

<?php
try{
	$db = getDb();
	$stt = $db->query('SELECT * FROM post ORDER BY id DESC');
	$stt->execute();
	$post_list = $stt->fetchAll();
	foreach ($post_list as $row){
			echo $row["id"]." ".$row["name"]." ".$row["contents"];
			echo '<br>';}
	$db = null;
	}catch(PDOException $e) {
		die("エラーメッセージ:{$e->getMessage()}");
}
	
		
	
?>
</body>
</html>