<?php
require ('Smarty.php');

$errorMessage ="";


if (isset($_SESSION["USERID"])) {
	
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}
$smartyObj->assign('errors', $errorMessage);

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();

$smartyObj->display('Logout_Smarty.tpl');
