<?php
//user.php v5.0.0

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');        
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');     

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
$users		= new Group('*');
//$users->fieldUpper('cn');
$users->sortBy($sort);
$users->tplTableInner('TABLE_TEXT', 
	Array('cn', 'objectsid'), 
	Array(FALSE, FALSE, FALSE), 
	Array(FALSE, FALSE, FALSE));
$tpl->parse('BODY', 'table');
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>