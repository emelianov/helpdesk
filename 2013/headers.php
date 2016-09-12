<?php

//headers.php v4.0.0

$now = getdate(time()+(-0*60)*60);
header('Content-type: text/html; charset=windows-1251');
$min	= $now['minutes'];
$hour	= $now['hours'];

$expire = 'Expires: '.gmdate("D, d M Y H:i:s", mktime($hour + 1, 0, 0, $now['mon'], $now['mday'], $now['year'])).' GMT';
header($expire);
// echo $expire;
?>