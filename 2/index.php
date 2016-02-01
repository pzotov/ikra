<?php
/**
 * Затрачено 1:02
 */

define('token', '33563bfa4ca6418db668570a1cdd4ebc');
define('client_id', '2f74ff3db0054dc1b512f1481dace72b');
define('secret_id', '1349ea84aba84b8abf4310a47e2ee66d');
define('counter_id', '35036235');

?>
<html>
<head>
	<title>Задание №2</title>
</head>
<body>
<?php
if($prefix = trim($_POST['prefix'])){
	$res = goal([
		'name' => 'Простая цель '.$prefix,
		'type' => 'action',
		'class' => 0,
		'is_retargeting' => 0,
		'conditions' => [[
			'type' => 'exact',
			'url' => $prefix
		]]
	]);
	dump($res);
	$res = goal([
		'name' => 'Составная цель '.$prefix,
		'type' => 'step',
		'class' => 0,
		'is_retargeting' => 0,
		'steps' => [
			[
				'name' => 'Шаг 1',
				'type' => 'action',
				'class' => 0,
				'is_retargeting' => 0,
				'conditions' => [[
					'type' => 'exact',
					'url' => $prefix
				]]
			], [
				'name' => 'Шаг 2',
				'type' => 'action',
				'class' => 0,
				'is_retargeting' => 0,
				'conditions' => [[
					'type' => 'exact',
					'url' => $prefix.'-level2'
				]]
			], [
				'name' => 'Шаг 3',
				'type' => 'action',
				'class' => 0,
				'is_retargeting' => 0,
				'conditions' => [[
					'type' => 'exact',
					'url' => $prefix.'-level3'
				]]
			]
		]
	]);
	dump($res);
}
?>
	<form action="" method="post">
		<input type="text" size="50" name="prefix" value="" placeholder="Префикс" required>
		<br><br>
		<button type="submit">Создать цели</button>
	</form>
</body>
</html>

<?php
function dump($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

function goal($goal) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL, 'https://api-metrika.yandex.ru/management/v1/counter/'.counter_id.'/goals?oauth_token='.token );
	curl_setopt($ch, CURLOPT_POST, 1 );
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['goal' => $goal]));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 );
//	curl_setopt($ch, CURLOPT_COOKIEJAR, _dir."cookie.txt");
//	curl_setopt($ch, CURLOPT_COOKIEFILE, _dir."cookie.txt");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36" );
	curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-yametrika+json"]);

	$buffer = curl_exec( $ch );
	return json_decode($buffer, true);
}