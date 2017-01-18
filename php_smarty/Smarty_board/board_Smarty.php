<?php

require ('Smarty.php');
require_once ('DbManager_Smarty.php');
require_once ('MyValidator_Smarty.php');

if (isset($_SESSION["USERID"])) {

	if(isset($_POST['toukou'])){

		$v = new MyValidator();
		$v->requiredCheck($_POST['contents'], 'メッセージ');
		$v->lengthCheck($_POST['contents'], 'メッセージ', 50);

		$contents = htmlspecialchars($_POST['contents']);

		$db = getDb();
		$stt = $db->prepare('INSERT INTO post(contents, user_id) VALUES(:contents, :user_id )');
		$stt->bindParam(':contents', $_POST['contents']);
		$stt->bindParam(':user_id', $_SESSION["USERID"]);
		$stt->execute();
		}


		$db = getDb();
		$stt = $db->query('SELECT * FROM post ORDER BY id DESC');
		$stt->execute();
		$post_list = $stt->fetchAll();

		} else {
		header("Location: Logout_Smarty.php");
}

	$smartyObj->assign('post_list', $post_list);
	$smartyObj->display('board_Smarty.tpl');

?>
