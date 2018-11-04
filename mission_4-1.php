<?php
$dsn = 'mysql:dbname=tt_421_99sv_coco_com;host=localhost';
$user = 'tt-421.99sv-coco.com';
$password = 'Y2bNJeta';
$pdo = new PDO($dsn,$user,$password);
$sql="CREATE TABLE tbtest"
."("
."id INT,"
."name char(32),"
."comment TEXT"
.");";
$stmt = $pdo->query($sql);

$filename = 'mission_2-2_Daigo.txt';
$name_value = "";
$comment_value = "";
$post_number_value = "";
$password_value = "";
if(isset($_POST["submit1"]) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password1"])){
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$password = $_POST["password1"];
	$date = date("Y年m月d日 H:i:s");
	$text_array = file($filename);
	if(!empty($_POST["post_number"])){
		$post_number = $_POST["post_number"];
		$fp = fopen($filename,"w");
		foreach($text_array as $value){
			$value = mb_convert_encoding($value,"UTF-8","SJIS");
			$text_explode_array = explode("<>",$value);
			if($post_number == $text_explode_array[0]){
				$text = $post_number."<>".$name."<>".$comment."<>".$date."<>".$password."\n";
				$text = (mb_convert_encoding($text,"SJIS", "UTF-8"));
				fwrite($fp, $text);
			}else{
				$text = (mb_convert_encoding($value,"SJIS", "UTF-8"));
				fwrite($fp, $text);
			}
		}
		fclose($fp);
	}else{
		$text_max = count(file($filename)) -1;
		if($text_max == -1){
			$number = 1;
		}else{
		$text_read = $text_array[$text_max];
		$text_read = mb_convert_encoding($text_read,"UTF-8","SJIS");
		$text_explode_array = explode("<>",$text_read);
		$number = $text_explode_array[0] +1;
		}
		$fp = fopen($filename,"a");
		$text = $number."<>".$name."<>".$comment."<>".$date."<>".$password."\n";
		$text = (mb_convert_encoding($text,"SJIS", "UTF-8"));
		fwrite($fp, $text);
		fclose($fp);
	}
}

if(isset($_POST["submit2"]) && !empty($_POST["delete"]) && !empty($_POST["password2"])){
	$delete = $_POST["delete"];
	$password = $_POST["password2"]."\n";
	$text_array = file($filename);
	$fp = fopen($filename,"w");
	foreach($text_array as $value){
		$value = mb_convert_encoding($value,"UTF-8","SJIS");
		$text_explode_array = explode("<>",$value);
		if($delete != $text_explode_array[0]){
			$text = (mb_convert_encoding($value,"SJIS", "UTF-8"));
			fwrite($fp, $text);
		}else{
			if($password != $text_explode_array[4]){
				echo "<h1>パスワードが違います。</h1>";
				$text = (mb_convert_encoding($value,"SJIS", "UTF-8"));
				fwrite($fp, $text);
			}
		}
	}
	fclose($fp);
}
if(isset($_POST["submit3"]) && !empty($_POST["editing"]) && !empty($_POST["password3"])){
	$editing = $_POST["editing"];
	$password = $_POST["password3"]."\n";
	$text_array = file($filename);
	foreach($text_array as $value){
		$value = mb_convert_encoding($value,"UTF-8","SJIS");
		$text_explode_array = explode("<>",$value);
		if($editing == $text_explode_array[0]){
			if($password == $text_explode_array[4]){
				$post_number_value = $text_explode_array[0];
				$name_value = $text_explode_array[1];
				$comment_value = $text_explode_array[2];
				$password_value = $text_explode_array[4];
			}else{
				echo "<h1>パスワードが違います。</h1>";
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" charset="UTF-8">
	</head>
	<body>
	<form action="mission_2-5.php" method="post">
	<input type="text" name="name" placeholder="名前"value="<?php echo $name_value; ?>"><br>
	<input type="text" name="comment" placeholder="コメント" value="<?php echo $comment_value; ?>"><br>
	<input type="hidden" name="post_number" value = "<?php echo $post_number_value; ?>"><br>
	<input type="text" name="password1" placeholder="パスワード" value="<?php echo $password_value;?>">
	<input type="submit" name="submit1" value="送信"><br><br>
	<input type="text" name="delete" placeholder="削除対象番号"><br>
	<input type="text" name="password2" placeholder="パスワード">
	<input type="submit" name="submit2" value="削除"><br><br>
	<input type="text" name="editing" placeholder="編集対象番号"><br>
	<input type="text" name="password3" placeholder="パスワード">
	<input type="submit" name="submit3" value="編集"><br><br>

</form>
	</body>
</html>

<?php
$text_array = file($filename);
foreach($text_array as $value){
	$value = mb_convert_encoding($value,"UTF-8","SJIS");
	$text_explode_array = explode("<>",$value);
	$text = $text_explode_array[0]." ".$text_explode_array[1]." ".$text_explode_array[2]." ".$text_explode_array[3];
	echo $text."<br>";
}
?>
