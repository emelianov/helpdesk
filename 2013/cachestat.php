<?php
//cachestat.php 4.3.0

require_once('config.php');
require_once(OLIB_PATH.'/class.cache.php');

$cache		= new Cache();

$ex		= $cache->valueOf(CACHE_NAMES);
$keys		= array_keys($ex);
echo "Names table\n";
foreach ($keys as $key) {
// echo "$key: ".date('d-m-Y H:i:s', $ex[$key])."\n";
 echo "$key:		".$ex[$key]."\n";
}
$ex		= $cache->valueOf(CACHE_EXPIRES);
$keys		= array_keys($ex);
echo "Expires table\n";
$invalid	= 0;
foreach ($keys as $key) {
 echo "$key:	".date('d-m-Y H:i:s', $ex[$key])."\n";
 if (time() > $ex[$key]) {
  $invalid++;
 }
}
echo "Statistics\n";
echo "Cache read:	".$cache->valueOf(CACHE_HIT)."\n";
echo "Cache miss:	".$cache->valueOf(CACHE_MISS)."\n";
echo "Cache write:	".$cache->valueOf(CACHE_STORE)."\n";
echo "Cache expired:	".$cache->valueOf(CACHE_EXPIRED)."\n";
echo "Expired entries:".$invalid."\n";

?>
