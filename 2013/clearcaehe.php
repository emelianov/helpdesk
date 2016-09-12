<?php

require_once('config.php');
require_once(OLIB_PATH.'/class.cache.php');

$cache		= new Cache();

echo "Statistics\n";
echo "Cache hit:	".$cache->valueOf(CACHE_HIT)."\n";
echo "Cache miss:	".$cache->valueOf(CACHE_MISS)."\n";
echo "Cache write:	".$cache->valueOf(CACHE_STORE)."\n";

$cache->destroy();
 
?>
