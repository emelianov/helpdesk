<?php
//cid.php v5.0.0

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');        
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');
require_once('lib5.php');

$tpl		= &initFastTemplate();
$tpl->define(array(     'pc_table'         => 'body.pc.table_head.tpl'
	    ));

$ses		= new Session(TRUE);
$tpl->assign('MESSAGE', $ses->msg());

if (isset($_GET['sort'])) {
 $sort		= $_GET['sort'];
} else {
 $sort		= 'cn';
}
$tpl->parse('TABLE_TEXT', 'pc_table');
$users		= new Request5();
$users->findBy();
$users->findBy('pid = 0');
$users->range(mktime(0,0,0,2,1,2014),86400*31);
//$users->findBy('saprname="Korzhov_OV"');
$users->_execute();
echo $users->count;
$tpl->parse('BODY', 'table');
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>