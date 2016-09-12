<?php
//user-person.php v5.0.1

setlocale(LC_ALL, 'ru_RU');

header('Content-type: application/octet-stream; charset=windows-1251');
header('Content-disposition: inline; filename=updusers.cmd');

require_once('config.php');        
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.wp2.php');        
require_once(OLIB_PATH.'/class.session.php');     

$tpl		= &initFastTemplate();
$tpl->define(array(     'pc_table'	=> 'body.pc.table_head.tpl',
			'export_vbs'	=> 'export/vbs.ad.modifyuser.tpl'
	    ));
/*
$ses		= new Session(TRUE);
$tpl->assign('MESSAGE', $ses->msg());

if (isset($_GET['sort'])) {
 $sort		= $_GET['sort'];
} else {
 $sort		= 'cn';
}
*/
$tpl->parse('TABLE_TEXT', 'pc_table');
$users		= new User('*');
$users->sortBy('cn');
foreach ($users->cn as $u) {
 $user		= new WpPerson($u);
 $user->retrive();
 if ($user->count > 0) {
  $i		= strpos($user->firstname[0], ' ');
  $otdel	= trim($user->otdel[0]);
  $otdel	= str_replace('разработки месторождений', 'разраб. местор.',$otdel);
  $otdel	= str_replace('РАЗРАБОТКИ НЕФТЕГАЗОВЫХ МЕСТОРОЖДЕНИЙ', 'РАЗРАБ. НЕФТЕГАЗОВЫХ МЕСТОР.', $otdel);
  $otdel	= str_replace('нефтегазовых месторождений', 'нефтегазовый местор.', $otdel);
  $otdel	= str_replace(' методами промысловой геофизики и гидродинамики', '', $otdel);
  $tpl->assign(	array(	'LASTNAME'	=> trim($user->lastname[0]),
			'FIRSTNAME'	=> trim($user->firstname[0]),
			'M'		=> substr($user->firstname[0], $i+1, 1),
			'TITLE'		=> trim($user->dolg[0]),
			'DEPARTMENT'	=> $otdel,
			'PHONENUMBER'	=> trim($user->note3[0]?trim($user->note3[0]):'-'),
			'LAB'		=> trim($user->laba[0]),
			'ROOM'		=> trim($user->room[0]),
			'LASTLAB'	=> trim($user->lastlaba[0]),
			'CN'		=> trim($user->lastname[0].' '.$user->firstname[0].',ou=Users'),
			'OUDC'		=> OLDAP_DN
		));
  $tpl->parse('BODY', '.export_vbs');
 }
}
/*
$users->tplTableInner('TABLE_TEXT', 
	Array('cn', 'telephonenumber', 'department'), 
	Array(FALSE, FALSE, FALSE), 
	Array(FALSE, FALSE, FALSE));
*/
//$tpl->parse('PAGE', 'empty');
$tpl->FastPrint();
?>