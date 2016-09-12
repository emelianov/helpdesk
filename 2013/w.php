<?php
//pc.php v5.2.0

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');     
require_once(OLIB_PATH.'/class.process.php');     

$tpl		= &initFastTemplate();
$tpl->define(array(     'pc_table'	=> 'body.pc.table_head.tpl',
			'pc'		=> 'body.pc.tpl',
			'process'	=> 'body.pc.process.tpl'
	    ));

$ses		= new Session(true);
$tpl->assign('MESSAGE', $ses->msg());


 $users		= new Computer('TONIPI-*');
 $users->tplLink('TABLE_TEXT', 'Export hosts file', 'hostsexport.php');
 $tpl->parse('TABLE_TEXT', '.pc_table');
 $users->fieldUpper('cn');
 $users->sortBy($sort);
 $users->tplTableInner('TABLE_TEXT', 
	array('cn', 'description', 'location'), 
	array(FALSE, FALSE, FALSE), 
	array(FALSE, FALSE, FALSE));
 $tpl->parse('BODY', 'table');
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>