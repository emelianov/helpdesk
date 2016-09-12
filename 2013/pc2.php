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

if (isset($_GET['sort'])) {
 $sort		= $_GET['sort'];
} else {
 $sort		= 'cn';
}
if (isset($_GET['name'])) {
 $pc		= new Computer($_GET['name']);
 $tpl->assign(	array(	'CN'				=> $pc->cn,
			'TITLE'				=> $pc->cn,
			'LOCATION'			=> $pc->location,
			'DESCRIPTION'			=> $pc->description,               
			'NAME'				=> $pc->name,                      
			'CREATE'			=> $pc->unixTimestampToString($pc->createtimestamp),           
			'LASTLOGON'			=> $pc->unixTimestampToString($pc->lastlogon),                 
			'LASTLOGONTS'			=> $pc->unixTimestampToString($pc->lastlogontimestamp),        
			'LOGONCOUNT'			=> $pc->logoncount,                
			'MODIFYTS'			=> $pc->unixTimestampToString($pc->modifytimestamp),           
			'OS'				=> $pc->operatingsystem,           
			'SP'				=> $pc->operatingsystemservicepack,
			'OSVER'				=> $pc->operatingsystemversion,    
			'PASSSET'			=> $pc->unixTimestampToString($pc->pwdlastset),                
			'CREATED'			=> $pc->unixTimestampToString($pc->whencreated),               
			'CHANGED'			=> $pc->unixTimestampToString($pc->whenchanged)
		));
  $gr		= $pc->groups();
  echo $gr->samaccountname[0];
  foreach ($gr->samaccountname as $group) {
   $gr->tplPlainHtml('MEMBEROF', $group.'<BR>');
  }
 $process	= new Process();
 $process->selectActiveProcesses($_GET['name']);
 $process->retrive();
 for ($i = 0; $i < $process->count; $i++) {
  $tpl->assign(	array(	'PROCESS'			=> $process->process[$i],
			'START'				=> $process->unixTimestampToString($process->start[$i]),
			'STOP'				=> $process->stop[$i]
		));
  $tpl->parse('PROCESS_LIST','.process');
 }
 $tpl->parse('BODY', 'pc');
} else {
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
}
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>