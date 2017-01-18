<?php
require ('Smarty.php');

$errorMessage ="";


if (isset($_SESSION["USERID"])) {

    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションが無効です。";
}
$smartyObj->assign('errors', $errorMessage);

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();

$smartyObj->display('Logout_Smarty.tpl');
