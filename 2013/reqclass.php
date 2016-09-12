<?php
//reqclass.php v2013.0

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');
require_once('lib5.php');
require_once(OLIB_PATH.'/class.session.php');

$tpl		= &initFastTemplate();
$tpl->define(array(     'pc_table'		=> 'body.pc.table_head.tpl',
			'req_edit'		=> 'body.request.edit.tpl'
	    ));

$ses		= new Session(true);
$tpl->assign('MESSAGE', $ses->msg());


if (isset($_GET['action'])) {
 $action	= $_GET['action'];
} elseif (isset($_POST['ACTION'])) {
 $action	= $_POST['ACTION'];
} else {
 $action	= 'display';
}
if (isset($_GET['rid'])) {
 $rid		= $_GET['rid'];
 switch ($action) {
  case 'display':
   $rid		= $_GET['rid'];
   $actData	= new Request($rid);
   $tpl->parse('TABLE_TEXT', 'pc_table');
   $users		= new RequestClass5();
   $users->retrive();
   $users->cids	= $actData->cid[0];
// $users->sortBy($sort);
   $users->tplTableInner('TABLE_TEXT', 
	array('id', 'cid', 'name'), 
	array(false, false, false), 
	array(false, false, false));
   $tpl->assign('FIELDS_ACTION', 'save');
   $tpl->parse('FIELDS_DATA', 'table');
   $tpl->parse('BODY', 'req_edit');
  break;
  case 'save':
   $actData	= new Request($rid);
   $actData->cid[0]= $_POST['CID'];
   $actData->update();
// echo $_POST['CID'];
// echo '<BR>';
// echo $rid;
  break;
 }
} else {

}
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>