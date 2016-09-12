<?php
//imp.pcounter.php v5.0.3

require_once('config.php');
include(OLIB_PATH.'/class.parser.php');
include(OLIB_PATH.'/class.printjob.php');
include(OLIB_PATH.'/class.cfg.php');

error_reporting(E_ERROR);
// setlocale(LC_ALL, 'ru_RU');

function toUnixTimestamp($d, $t) {
 return mktime(substr($t, 0, 2), substr($t, 3, 2), 0, substr($d, 3, 2), substr($d, 0, 2), substr($d, 6, 4));
}

$fn			= '/home/webserver/PCOUNTER.LOG';
//$fn			= '/home/webserver/PCOUNTER_2010_06.LOG';
$cn			= 'printjoblogposition';
$tst			= new Parser(	Array(	'username',
					'document', 
					'prnname', 
					'date', 
					'time', 
					'pc', 
					'f1', 
					'f2', 
					'paper', 
					'param', 
					'size', 
					'pages', 
					'n1', 
					'n2'
				), ',');
$tst->fileOpen($fn, $cn);
while ($str = $tst->fileStr()) {
 $tst->load($str);
 $ora			= new PrintJob();
 $ora->username[0]	= substr($tst->username, 4);
 $ora->docum[0]		= convert_cyr_string(addslashes(str_replace('\'','',$tst->document)), 'd', 'w');
 $ora->prnname[0]	= substr($tst->prnname, strpos($tst->prnname, '\\', 3) + 1);
 $ora->pcname[0]	= substr($tst->pc, 2);
 $ora->paper[0]		= $tst->paper;
 $ora->pages[0]		= $tst->pages;
 $ora->bsize[0]		= $tst->size; 
 $ora->time[0]		= toUnixTimestamp($tst->date, $tst->time);
 $param			= explode('/', $tst->param);
 $ora->jt[0]		= substr($param[1], 3);
 $ora->cp[0]		= substr($param[2], 3);
 $ora->ts[0]		= substr($param[3], 3);
 $ora->count		= 1;
 $ora->insert();
}
$tst->commit();
?>