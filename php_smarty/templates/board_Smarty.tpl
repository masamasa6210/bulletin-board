<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>簡易掲示板</title>
</head>
<body>
	<h1>簡易掲示板</h1></br>
	
	<a href="Logout_Smarty.php">ログアウト</a> <a href="delete_Smarty.php">削除</a> <a href="edit_Smarty.php">編集</a>
	
	<p>ようこそ<u>{$smarty.session.USERID}</u><u>{$smarty.session.NAME}</u>さん</p>
	<div><font color="#ff0000">{$errors}</font></div>
	<p>メッセージは50文字以内で入力してください</p>

	<form action="" method="POST">

	メッセージ:<input type="text" name="contents" autocomplete="off">

	<input type="submit" name='toukou'　value="投稿"></br></br>

	{foreach from=$post_list item=row}
	<p>{$row.id} {$row.contents} {$row.user_id}</p>
	{/foreach}

	</form>

</body>
</html>