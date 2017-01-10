<?php /* Smarty version 2.6.30, created on 2017-01-06 08:25:44
         compiled from board_Smarty.tpl */ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>簡易掲示板</title>
</head>
<body>
	<h1>簡易掲示板</h1></br>
	
	<a href="Logout_Smarty.php">ログアウト</a> <a href="delete_Smarty.php">削除</a> <a href="edit_Smarty.php">編集</a>
	
	<p>ようこそ<u><?php echo $_SESSION['USERID']; ?>
</u><u><?php echo $_SESSION['NAME']; ?>
</u>さん</p>
	<div><font color="#ff0000"><?php echo $this->_tpl_vars['errors']; ?>
</font></div>
	<p>メッセージは50文字以内で入力してください</p>

	<form action="" method="POST">

	メッセージ:<input type="text" name="contents" autocomplete="off">

	<input type="submit" name='toukou'　value="投稿"></br></br>

	<?php $_from = $this->_tpl_vars['post_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
	<p><?php echo $this->_tpl_vars['row']['id']; ?>
 <?php echo $this->_tpl_vars['row']['contents']; ?>
 <?php echo $this->_tpl_vars['row']['user_id']; ?>
</p>
	<?php endforeach; endif; unset($_from); ?>

	</form>

</body>
</html>