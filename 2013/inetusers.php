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
$ext		= new Group('Group-TONIPI Internet users');
//echo $ext->cn[0];
$users		= $ext->users();
//$users->fieldUpper('cn');
$users->sortBy($sort);
$users->tplTableInner('TABLE_TEXT', 
	Array('cn', 'title', 'samaccountname'), 
	Array(FALSE, FALSE, FALSE, false), 
	Array(FALSE, FALSE, FALSE, false));
$tpl->parse('BODY', 'table');
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>