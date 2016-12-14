<?php
require_once 'C:\xampp\htdocs\php_data\DbManager.php';

date_default_timezone_set('Asia/Tokyo');

$dataFile ='bbs.txt';

if(isset($_POST['toukou'])){	
	$name = htmlspecialchars($_POST['name']);
	$contents = htmlspecialchars($_POST['contents']);
	$postedAt = date('Y-m-d H:i:s');
	
	if(strlen($name) > 20 or strlen($contents) > 50 ){
		
		print "文字数が多すぎます";
		echo '<br>';
		echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
		exit;
	}

	if(!empty($_POST['name']) && !empty($_POST['contents'])){
		$newData = (sizeof(file($dataFile)) + 1)." ".$name." ".$contents." ".$postedAt. "\n";

		$fp = fopen($dataFile,'a');
	    fwrite($fp, $newData);
	    fclose($fp);
	}else{
		print '値を入れてください';
		echo '<br>';
		echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
		exit;
	}
}

	try {
	$db = getDb();
		
	$stt = $db->prepare('INSERT INTO bulletin(name, contents) VALUES(:name, :contents)');
		
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
     
    $file=file($dataFile); // ファイルの内容を配列に格納
    foreach( $file as $value ){
    $line = explode(" ",$value);
    echo $value."<br />\n"; // 改行しながら値を表示
	}
?>
</body>
</html>

