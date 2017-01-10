<?php
require_once 'DbManager_Smarty.php';

class MyValidator {
	public $_errors;

	public function __construct() {
		$_errors = array();
	}

	public function requiredCheck($value, $name) {
		if(trim($value) === ''){
			echo $this->_errors[] = "{$name}は必須入力です。";
			echo '<br>';
			echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
			exit;
		}
	}

	public function lengthCheck($value, $name, $len) {
		if(trim($value) !== ''){
			if(mb_strlen($value) > $len){
				echo $this->_errors[] = "{$name}は{$len}文字以内で入力してください。";
				echo '<br>';
				echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
				exit;
			}
		}
	}

	public function intTypeCheck($value, $name){
		if (trim($value) !== ''){
			if(!ctype_digit($value)) {
				echo $this->_errors[] = "{$name}は数値で指定してください。";
				echo '<br>';
				echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
				exit;
			}
		}
	}
	
	public function altumTypeCheck($value, $name){
		if (trim($value) !== ''){
			if(!ctype_alnum($value)) {
				echo $this->_errors[] = "{$name}は英数字で指定してください。";
				echo '<br>';
				echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
				exit;
			}
		}
	}

	public function regexCheck($value, $name){
		if (trim($value) !== ''){
			if(!preg_match("/^.{4,8}$/",$value)) {
				echo $this->_errors[] = "{$name}は4文字以上8文字以下で指定してください。";
				echo '<br>';
				echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
				exit;
			}
		}
	}

	


}

?>
