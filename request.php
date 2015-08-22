<?php
//request.php v5.0.10
//
// Emelianov's HelpDesk
// (c)2006-2014 Alexander Emelianov (a.m.emelianov@gmail.com)
//

require_once('config.php');
$i			= strrpos(__FILE__, '/');
$_file_			= substr(__FILE__, $i + 1);
switch ($_file_) {
 case 'pdm.php':
  define('OREQ_TABLE',	OREQ_PDM_TABLE);
  $admin		= OREQ_PDM_ADMIN;
  $userlist		= OREQ_PDM_USERLIST;
  $inform		= OREQ_PDM_INFORM;
  $title		= OREQ_PDM_TITLE;
  $fts			= OREQ_PDM_FTS_TBL;
  $css			= OREQ_PDM_CSS;
 break;
 case 'omts.php':
  define('OREQ_TABLE',	OREQ_OMTS_TABLE);
  define('OREQ5_BREF',	1024);
  $admin		= OREQ_OMTS_ADMIN;
  $userlist		= OREQ_OMTS_USERLIST;
  $inform		= OREQ_OMTS_INFORM;
  $title		= OREQ_OMTS_TITLE;
  $fts			= OREQ_OMTS_FTS_TBL;
  $css			= OREQ_OMTS_CSS;
 break;
default:
 define('OREQ_TABLE',	OREQ_ALL_TABLE);
  define('OREQ5_BREF',	100);
 $admin			= OREQ_ADMIN;
 $userlist		= OREQ_USERLIST;
 $inform		= OREQ_INFORM;
 $title			= OREQ_TITLE;
// $fts			= OREQ_FTS_TBL;
 $fts			= OREQ_TABLE;
 $css			= OREQ_CSS;
}
$reqtable		= OREQ_TABLE;
require_once('lib5.php');
require_once(OLIB_PATH.'/class.ad.php');
require_once(OLIB_PATH.'/class.session.php');
require_once(OLIB_PATH.'/class.cache.php');
require_once(OLIB_PATH.'/class.utils.php');

if (!defined('ROWS_PER_PAGE')) {
 define('ROWS_PER_PAGE', 50);
}
define('REQ_PROCESS',	'Создана новая заявка/операция');
define('REQ_DONE',	'Заявка/операция выполнена');
define('REQ_UNDO',	'Операция возвращена в состояние "В РАБОТЕ"');
define('REQ_TAKE',	'Заявка/операция принята к исполнению');
define('REQ_CANCEL',	'Операция отклонена');
define('REQ_DELAY',	'Заявка отложена');
define('REQ_REM',	'Добавлен комментарий');
define('REQ_USERREM',	'User added comment');
define('REQ_TAKE_TEXT',	'Принять ответственность');
define('REQ_TAKE_OVER',	'Перехватить ответственность');

function inform($actData, $login, $act) {
 global $tpl;
 global $_file_;
 $url	= SERV_PATH.'/'.$_file_.'?pid='.($actData->pid[0]?$actData->pid[0]:$actData->rid[0]);
 $tpl->assign('BODY', "$act <BR>Изменения внес: $login <BR>".
	"Подробная информация доступна по адресу <A HREF=\"$url\">$url</A>");
 $tpl->parse('EMAIL', 'email');
 $headers	= OUSER_MAILFROM."\r\n";
 $headers	.= "MIME-Version: 1.0\r\n";
 $headers	.= "Content-type: text/html; charset=windows-1251";
 trigger_error('Inform data (pid/rid, saprname, curator): '.$actData->pid[0].'/'.$actData->rid[0].' '.$actData->saprname[0].', '.$login);
 if (isset($actData->saprname[0]) && $actData->saprname[0] != $login) {
  $user			= new User($actData->saprname[0]);
  $user->send(	'Статус заявки изменен',
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers
	);
 }
 if ($actData->username[0] != $login && $actData->username[0] != $actData->saprname[0]) {
  $user			= new User($actData->username[0]);
  $user->send(	'Статус заявки изменен',
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers
	);
 }
 if ($actData->pid[0]) {
  $reqRoot		= new Request5($actData->pid[0]);
  if ($reqRoot->curator[0] != $login && $reqRoot->curator[0] != $actData->saprname[0] && $reqRoot->curator[0] != $actData->username[0]) {
   $user			= new User($reqRoot->curator[0]);
   $user->send(	'Статус заявки изменен',
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers
	);  
  }
 } else {
  if (	$actData->targetname[0] != $login && 
	$actData->targetname[0] != $actData->saprname[0] && 
	$actData->targetname[0] != $actData->username[0] &&
	$actData->targetname[0] != $actDAta->curator[0]) {
   $user			= new User($reqRoot->targetname[0]);
   $user->send(	'Статус заявки изменен',
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers
	);  
  }

 }
}

function comment($actData, $postVar, $login) {
 if (isset($_POST[$postVar]) && strlen($_POST[$postVar]) > 0) {
  if (strlen($actData->text[0]) > 0 ) {
   $actData->text[0]	.= "\n";
  }
  $actData->text[0]	.= date('d-m-y H:i', time()).' '.$login.' '.$_POST[$postVar];
 }
}

function person($login, $var=false) {
 if (!$var) {
  $var			= 'TMP_VAR';
 }
 $to			= new _Obj();
 $to->_tpl->clear($var);
 $to->tplLink($var, $login, 'mailto:'.$login);
 return $to->_tpl->get_assigned('TMP_VAR');
}

$tpl			= &initFastTemplate();
$tpl->define(array(	'step0'		=> 'reqs/step0.tpl',
			'step1'		=> 'reqs/step1.tpl',
			'step2'		=> 'reqs/step2.tpl',
			'step3'		=> 'reqs/step3.tpl',
			'step4'		=> 'reqs/step4.tpl',
			'new'		=> 'reqs/new.tpl',
		        'list'		=> 'body.request.list.tpl',
		        'listu'		=> 'body.request.list.forusers.tpl',
			'detales'	=> 'body.request.detales.tpl',
			'forusers'	=> 'body.request.forusers.tpl',
			'header1'	=> 'body.request.header1.tpl',
			'header2'	=> 'body.request.header2.tpl',
			'closed_comm'	=> 'body.request.closed.user.tpl',
			'closed_undo'	=> 'body.request.closed.admin.tpl',
			'email'		=> 'email.tpl'
                ));                                               
$ses 			= new Session5();
$tpl->assign('MESSAGE', $ses->msg());
$cache			= new Cache();
$groupWebAdmin		= new Group($admin);
$groupWebSAPR		= new Group($userlist);
$groupWebInform		= new Group($inform);
$tpl->assign('TITLE_REQ', $title);
$tpl->assign('CSS', $css);
$ses->getParams(array(  'sort'), true);
$sort			= $ses->valueOf('filter.sort');
$sort			= $sort[0];
if ($sort == 'result') {
 $sort			= false;
}
$myreq			= $ses->valueOf('filter.myreq')?true:false;
$donereq		= $ses->valueOf('filter.donereq')?true:false;
if (isset($_GET['page'])) {
 $rowFrom		= $_GET['page'] * ROWS_PER_PAGE;
} else {
 $rowFrom		= 0;
}

if ((isset($_GET['rid']) || isset($_POST['RID'])) && ($groupWebSAPR->isMember($ses->login()) || $_POST['ACTION'] == 'usercomment')) {
 if (isset($_GET['rid'])) {
  $rid			= $_GET['rid'];
 } else {
  $rid			= $_POST['RID'];
 }
 $actData		= new Request5($rid);
 $user			= $_POST['USER_LIST'];
 switch (@$_POST['ACTION']) {
  case 'process':
   $actData		= new Request5();
   $actData->pid	= $rid;
   $actData->time	= time();
   $actData->username	= $ses->login();
   $actData->saprname	= $user;
   $actData->action	= OREQ_PROCESS;
   $actData->result	= OREQ_WAIT;
   $actData->text	= $_POST['TEXT'];
   $actData->count	= 1;
   $actData->toMulti();
   $actData->insert();
   inform($actData, $ses->login(), REQ_PROCESS);
   break;
  case 'curator':
  case 'take':
   if ($actData->pid[0]) {
    if (!$actData->done[0]) {
     if (!$actData->time2[0]) {
      $actData->time2[0]	= time();
      $actData->saprname[0]= $ses->login();
      $actData->result[0]= OREQ_PROCESS;
      comment($actData, 'TEXT', $ses->login());
      $actData->update();
      inform($actData, $ses->login(), REQ_TAKE);
     } else {
      $ses->msg('Операция уже обрабатывается. ('.$actData->saprname[0].')');
     }
    } else {
     $ses->msg('Операция уже завершена.');
    }
   } else {
    if ($groupWebAdmin->isMember($ses->login())) {
     if (!$actData->time2[0]) {
      $actData->time2[0]= time();
      $actData->saprname[0]= $ses->login();
      $actData->curator[0]= $ses->login();
      $actData->result[0]= OREQ_PROCESS;
      $actData->update();
      inform($actData, $ses->login(), REQ_TAKE);
     } else {
      $ses->msg('Ответственный за заявку уже установлен. ('.$actData->curator[0].')');
     }
    } else {
     $ses->msg('Нет полномочий для установки ответственного за заявку.');
    }
   }
   break;
  case 'overtake':
    if ($groupWebAdmin->isMember($ses->login())) {
      $actData->time2[0]= time();
      $actData->saprname[0]= $ses->login();
      $actData->curator[0]= $ses->login();
      $actData->result[0]= OREQ_PROCESS;
      $actData->update();
      inform($actData, $ses->login(), REQ_TAKE);
    } else {
     $ses->msg('Нет полномочий для установки ответственного за заявку.');
    }
   break;
  case 'delay':
   if (!$actData->done[0]) {
    if (!$actData->pid[0]) {
     if ($actData->curator[0] == $ses->login() || $groupWebAdmin->isMember($ses->login())) {
      $childData	= new Request5();
      $childData->retriveActiveTasks($actData->rid[0]);
      if ($childData->count == 0) {
       $actData->result[0]= OREQ_DELAY;
//       comment($actData, 'TEXT', $ses->login());
       $actData->update();
       inform($actData, $ses->login(), REQ_DELAY);
      } else {
       $ses->msg('Нельзя отложить заявку имеющую незавершенные операции.');
      }
     } else {
      $ses->msg('В доступе отказано');
     }
    } else {
     $ses->msg('Не реализовано. Используйте ОТЛОЖИТЬ.');
    }
   } else {
    $ses->msg('Операция уже завершена.');
   }
  break;
  case 'end':
  case 'done':
   if (!$actData->done[0]) {
    if ($actData->pid[0]) {
     if ($actData->time2[0]) {
      if ($actData->saprname[0] == $ses->login() || $groupWebAdmin->isMember($ses->login())) {
       $actData->done[0]= time();
       $actData->username2[0]= $ses->login();
       $actData->result[0]= OREQ_DONE;
       comment($actData, 'TEXT', $ses->login());
       $actData->update();
       inform($actData, $ses->login(), REQ_DONE);
      } else {
       $ses->msg('Нет прав на завершение чужой операции.');
      }
     } else {
      $ses->msg('Операция ещё не принята к исполнению.');
     }
    } else {
     if ($actData->curator[0]) {
      if ($actData->curator[0] == $ses->login() || $groupWebAdmin->isMember($ses->login())) {
       $childData	= new Request5();
       $childData->retriveActiveTasks($actData->rid[0]);
       if ($childData->count == 0) {
        $actData->done[0]= time();
        $actData->username2[0]= $ses->login();
        $actData->result[0]= OREQ_DONE;
        $actData->update();      
        inform($actData, $ses->login(), REQ_DONE);
       } else {
        $ses->msg('Нельзя завершить задачу с незавершенными операциями.');
       }
      } else {
       $ses->msg('В доступе отказано.');
      }
     } else {
      $ses->msg('В доступе отказано.');
     }
    }
   } else {
    $ses->msg('Операция уже выполнена.');
   }
   break;
  case 'unend':
   if (!$actData->pid[0] && ($actData->curator[0] == $ses->login() || $groupWebAdmin->isMember($ses->login()))) {
    $actData->done[0]= false;
    $actData->username2[0]= $ses->login();
    $actData->result[0]= OREQ_PROCESS;
    $actData->update();      
    inform($actData, $ses->login(), REQ_UNDO);
   } else {
    $ses->msg('В доступе отказано.');
   }
   break;
  case 'usercomment':
   if (strlen($actData->comment[0]) > 0 ) {
    $actData->comment[0]	.= "\n";
   }
   $actData->comment[0]	.= date('d-m-y H:i', time()).' '.$ses->login().' '.$_POST['TEXT'];
   $actData->update();
   inform($actData, $ses->login(), REQ_USERREM);
   break;
  case 'timeout':
   if (!$actData->username2[0]) {    
    $actData->done[0]	= time();
    $actData->username2[0]= $ses->login();
    $actData->result[0]	= OREQ_TIMEOUT;
    comment($actData, 'TEXT', $ses->login());
    $actData->update();
    inform($actData, $ses->login(), REQ_CANCEL);
   } else {
    $ses->msg('Операция уже выполнена.');
   }
   break;
  case 'comment':
   if (strlen($actData->text[0]) > 0 ) {
    $actData->text[0]	.= "\n";
   }
   $actData->text[0]	.= date('d-m-y H:i', time()).' '.$ses->login().' '.$_POST['TEXT'];
   $actData->update();
   inform($actData, $ses->login(), REQ_REM);
  break;
  case 'delete':
   $ses->msg('Не реализовано. Используйте Отклонить.');
  break;
  default:
 }
  if ($actData->pid[0] == 0) {
   $url			= '?pid='.$actData->rid[0];
  } else {
   $url			= '?pid='.$actData->pid[0];
  }
  header("Location: $url");
  $tpl->assign('BODY',	"Если браузер не перешел автоматически используйте ссылку:<BR><A HREF='$url'>Просмотр заявки</A>");
} else {
 switch (@$_GET['action']) {
  case 'usercomment':
  ech();
   if (isset($_GET['rid'])) {
    $rid		= $_GET['rid'];
   } else {
    $rid		= $_POST['RID'];
   }
   $actData		= new Request5($rid);
   if (strlen($actData->comment[0]) > 0 ) {
    $actData->comment[0]	.= "\n";
   }
   $actData->comment[0]	.= date('d-m-y H:i', time()).' '.$ses->login().' '.$_POST['TEXT'];
   $actData->update();
   inform($actData, $ses->login(), REQ_USERREM);
   break;
  case 'donereq':
  case 'myreq':
  case 'allreq':
  case 'fulltext':
   $ses->dispose('filter.myreq');
   $ses->dispose('filter.allreq');
   $ses->dispose('filter.donereq');
   $ses->dispose('filter.user');
   $ses->dispose('filter.fulltext');
   switch ($_GET['action']) {
    case 'donereq':
     $ses->valueOf('filter.donereq', true);
     break;
    case 'myreq':
     $ses->valueOf('filter.myreq', true);
     if (isset($_GET['user'])) {
      $ses->valueOf('filter.user', $_GET['user']);
     }
     break;
    case 'fulltext':
     $ses->valueOf('filter.fulltext', $_GET['value']);
     break;
    case 'allreq':
     break;
   }
   $url		= $_file_;
   header("Location: $url");
   $tpl->assign('BODY',"Если браузер не перешел автоматически используйте ссылку:<BR><A HREF='$url'>Просмотр заявки</A>");
   break;
  case 'new':
   $user			= new User($ses->login());
   for ($i=0; $i < count($user->userworkstations); $i++) {
    if (strtolower($user->userworkstations[$i]) != 'tonipi-dc-01') {
     $tpl->assign('USERPC', $user->userworkstations[$i]);
    }
   }
   $tpl->assign('LOGIN', $ses->login());
   $tpl->assign('URL',	'?action=save');
   $tpl->assign('TITLE',	'New - Requests - TO');      
   if ($u = $cache->valueOf('LOGIN_USERLIST')) {                               
    $tpl->assign('SELECT_LIST', $u);                                             
   } else {                                                                    
    $users                = new User(OUSER_ALL);                               
//    $users->removeDisabled();                                                  
    $users->sortBy('cn');                                                      
    $users->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');             
    $cache->valueOf('LOGIN_USERLIST', $tpl->get_assigned('SELECT_LIST'), USERLIST_TTL);
   }
   $tpl->assign('SELECT_NAME', 'TARGET');
   $tpl->parse('USER_LIST', 'select');
   if ($groupWebSAPR->isMember($ses->login())) {
    if (!$groupWebAdmin->isMember($ses->login())) {
     $curators		= $groupWebAdmin->users();
     $curators->push();
     $curators->cn[$curators->count-1]= $ses->valueOf('cn');
     $curators->samaccountname[$curators->count-1]= $ses->login();     
    } else {
     $curators		= $groupWebSAPR->users();
    }
    $curators->push();
    $curators->cn[$curators->count-1]= '_Auto';
    $curators->sanaccountname[$curators->count-1]= '';
    $curators->sortBy('cn');
    $curators->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');
    $tpl->assign('SELECT_NAME', 'CURATOR');
    $tpl->parse('USER_LIST2', 'select');
   } else {
    $tpl->assign(array(	'USER_LIST2'	=> '_Auto'
		));
   }
   if ($u = $cache->valueOf('ALL_PC_LIST')) {                               
    $tpl->assign('LIST', $u);                                             
   } else {                                                                     
    $pc			= new Computer('*');
    $pc->sortBy('description');
    $pc->tplComboboxInner('LIST', 'description', 'cn');   
    $cache->valueOf('ALL_PC_LIST', $tpl->get_assigned('LIST'), 604800);
   }
   $tpl->parse('BODY',	'new');
   break;
  case 'save':
   $reqData			= new Request5();
   if ($groupWebSAPR->isMember($ses->login())) {
    if (isset($_POST['TARGET'])) {
     $reqData->curator		= (strlen($_POST['CURATOR']) > 0)?$_POST['CURATOR']:false;
     $reqData->saprname		= $reqData->curator;
    }
   } else {
    $reqData->curator		= false;
    $reqData->sapruser		= false;
   }
   $reqData->targetname	= $_POST['TARGET'];
   if (isset($_POST['OBJ'])) {
    $reqData->pcname	= $_POST['OBJ'];
   }
  case 'finish':
   if (!$reqData) {
    $reqData = $ses->valueOf('tmp_request');
   }
   $reqData->text	= $_POST['TEXT'];
   $reqData->time	= time();
//   $reqData->action	= OREQ_CREATE;
   if ($reqData->curator) {
    $reqData->result	= OREQ_PROCESS;
   } else {
    $reqData->result	= OREQ_WAIT;
   }
   $reqData->file	= '';
   $reqData->username	= $ses->login();
   if (isset($_FILES['FILENAME']['name']) && $_FILES['FILENAME']['name'] != '') {
    $ext			= substr($_FILES['FILENAME']['name'], strrpos($_FILES['FILENAME']['name'], '.'));
    $fn			= genFileName($ext);
    print_r($_FILES);
    move_uploaded_file($_FILES['FILENAME']['tmp_name'], PWD_FILES.'/'.$fn);
    $reqData->file	= $fn;
   }
   $reqData->count	= 1;
   $reqData->toMulti();
   $reqData->insert();                                                        
   $reqData->rid[0]	= $reqData->lastid();
   $url	= SERV_PATH.'/'.$_file_.'?pid='.$reqData->rid[0];
   $tpl->assign('BODY', "$act <BR>Изменения внес: ".$ses->login()." <BR>".
		"Подробная информация доступна по адресу <A HREF=\"$url\">$url</A>");
   $tpl->parse('EMAIL', 'email');
   $headers	= OUSER_MAILFROM."\r\n";
   $headers	.= "MIME-Version: 1.0\r\n";
   $headers	.= "Content-type: text/html; charset=windows-1251";
   if (!$reqData->curator[0]) {
    $us			= $groupWebInform->users();
    $us->send(	'Создана заявка', 
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers);
   } else {
    if ($reqData->curator[0] != $ses->login()) {
     $us			= new User($reqData->curator[0]);
     $us->send(	'Создана заявка',
		"\r\n".$tpl->get_assigned('EMAIL'),
		$headers);
    }
   }
   if ($groupWebSAPR->isMember($ses->login())) {
    if ($reqData->curator[0] && !$groupWebAdmin->isMember($reqData->curator[0])) {
     $actData		= new Request5();
     $actData->pid	= $reqData->rid[0];
     $actData->time	= time();
     $actData->username	= 'WebServer';
     $actData->saprname	= $reqData->curator[0];
     $actData->action	= OREQ_PROCESS;
     $actData->result	= OREQ_WAIT;
     $actData->count	= 1;
     $actData->toMulti();
     $actData->insert();
    }
   }
   $url			= '?pid='.$reqData->lastid();
   header("Location: $url");
   $tpl->assign('BODY',	"Если браузер не перешел автоматически используйте ссылку:<BR><A HREF='$url'>Просмотр заявки</A>");
   break;
  case 'step0':
   $reqData		= new Request5();
   $tpl->assign('URL',	'?action=step1');
   $tpl->assign('TITLE',	'0% - New - Requests - TO');
   if ($groupWebSAPR->isMember($ses->login())) {
    $users		= new User(OUSER_ALL);
    $users->sortBy('cn');
//    $users->removeDisabled();
    $users->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');
    $tpl->assign('SELECT_NAME', 'TARGET');
    $tpl->parse('USER_LIST', 'select');
    if (!$groupWebAdmin->isMember($ses->login())) {
     $curators		= $groupWebAdmin->users();
     $curators->push();
     $curators->cn[$curators->count-1]= $ses->valueOf('cn');
     $curators->samaccountname[$curators->count-1]= $ses->login();     
    } else {
     $curators		= $groupWebSAPR->users();
    }
    $curators->push();
    $curators->cn[$curators->count-1]= '_Auto';
    $curators->sanaccountname[$curators->count-1]= '';
    $curators->sortBy('cn');
    $curators->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');
    $tpl->assign('SELECT_NAME', 'CURATOR');
    $tpl->parse('USER_LIST2', 'select');
   } else {
    $tpl->assign(array(	'USER_LIST'	=> $ses->login(),
			'USER_LIST2'	=> '_Auto'
		));
   }
   $tpl->parse('BODY',	'step0');
   $ses->valueOf('tmp_request', $reqData);
   break;
  case 'step1':
   $reqData		= $ses->valueOf('tmp_request');
   if ($groupWebSAPR->isMember($ses->login())) {
    if (isset($_POST['TARGET'])) {
     $reqData->targetname	= $_POST['TARGET'];
     $reqData->curator		= (strlen($_POST['CURATOR']) > 0)?$_POST['CURATOR']:false;
     $reqData->saprname		= $reqData->curator;
    }
   } else {
    $reqData->targetname	= $ses->login();
    $reqData->curator		= false;
    $reqData->sapruser		= false;
   }
   $rc			= new RequestClass();
   $rc->retrive();
   $rc->tplComboboxInner('LIST', 'name', 'id');
   $tpl->assign( array(	'TARGET'	=> $reqData->targetname,
			'URL'		=> '?action=step2',
			'TITLE'		=> '33% - New - Requests - TO'
		));
   $tpl->parse('BODY',	'step1');
   $ses->valueOf('tmp_request', $reqData);
   break;
  case 'step2':
   $reqData		= $ses->valueOf('tmp_request');
   if (isset($_POST['CLASS_ID'])) {
    $reqData->cid	= $_POST['CLASS_ID'];
   }
   $cidData		= new RequestClass($reqData->cid);
   $pc			= new Computer('*');
   $pc->sortBy('description');
   $pc->tplComboboxInner('LIST', 'description', 'cn');
   $tpl->assign( array(	'TARGET'	=> $reqData->targetname,
			'CLASS'		=> $cidData->name[0],
			'BACK_URL'	=> '?action=step1',
			'URL'		=> '?action=step3',
			'TITLE'		=> '66% - New - Requests - TO'
		));
   $tpl->parse('BODY',	'step2');
   $ses->valueOf('tmp_request', $reqData);
   break;
  case 'step3':
   $reqData		= $ses->valueOf('tmp_request');
   if (isset($_POST['OBJ'])) {
    $reqData->pcname	= $_POST['OBJ'];
   }
   $cidData		= new RequestClass($reqData->cid);
   $tpl->assign( array(	'PC'		=> $reqData->pcname,
			'TARGET'	=> $reqData->targetname,
			'CLASS'		=> $cidData->name[0],
			'BACK_URL'	=> '?action=step2',
			'URL'		=> '?action=finish',
			'TITLE'		=> '100% - New - Requests - TO'
		));
   $tpl->parse('BODY',	'step4');
   $ses->valueOf('tmp_request', $reqData);
   break;
  default:
   $rid			= isset($_GET['pid'])?$_GET['pid']:false;
   if ($ses->valueOf('filter.user')) {
    $tpl->assign('TITLE', $ses->valueOf('filter.user').' - '.$title.' - TO');
   } else {
    $tpl->assign('TITLE', $title.' - ТО');
   }
   if ($rid === false) {
    $reqData		= new Request5();
    if (!$sort) {
     $reqData->orderBy(OREQ_TABLE.'.result');
     $reqData->orderBy(OREQ_TABLE.'.time', true);
    } else {
     if ($sort == 'time') {
      $reqData->orderBy($sort, true);
     } else {
      $reqData->orderBy($sort);
     }
    }
    if ($rowFrom) {
     $reqData->fromRow($rowFrom);
    }
    $reqData->rowCount(ROWS_PER_PAGE);
    $login		= $ses->valueOf('filter.user')?$ses->valueOf('filter.user'):$ses->login();
//    $login		= $ses->login();
//    $q_user		= " SELECT rid FROM requests 
//			    WHERE (pid IS NULL OR pid = 0) AND (targetname='$login' OR username='$login')";
//    $q_user		= " ((pid IS NULL OR pid = 0) AND (targetname='$login' OR username='$login'))";
    $q_user		= " ((targetname='$login' OR username='$login') AND pid=0)";
//    $q_user		= " (pid = 0 AND targetname='$login')";
/*    $q_sapr		= " SELECT pid as rid FROM $reqtable 
			    WHERE NOT(pid IS NULL OR pid=0) AND 
				    (saprname='$login' OR username='$login' OR username2='$login')
			    UNION
			    SELECT rid as rid FROM $reqtable
			    WHERE (pid IS NULL OR pid=0) 
				AND username='$login' OR targetname='$login' OR curator='$login'";
*/
    $q_sapr		= " SELECT IF(pid=0,rid,pid) AS rid FROM $reqtable WHERE saprname='$login' OR username='$login' OR username2='$login' OR targetname='$login'";
    $done		= OREQ_DONE;
    $timeout		= OREQ_TIMEOUT;
//    $q_done		= " SELECT pid AS rid FROM $reqtable WHERE !(result<>$done AND result<>$timeout) AND pid<>0";
    $q_done		= " SELECT rid FROM $reqtable
			    WHERE 
			     !(rid IN (SELECT pid FROM $reqtable WHERE result<>$done AND result<>$timeout AND pid<>0)) 
			     AND result <> $done AND pid=0";
/*
    $q_done		= " SELECT rid FROM $reqtable
			    WHERE 
			     !(rid IN (SELECT pid FROM $reqtable WHERE NOT(pid IS NULL OR pid=0) AND (result<>$done AND result<>$timeout))) AND 
			    (pid IS NULL OR pid=0) AND 
			     result <> $done";
*/
//    $q_fulltext		= " SELECT IF(pid = 0,rid,pid) AS id FROM $fts WHERE MATCH (text) AGAINST ('".$ses->valueOf('filter.fulltext')."' IN BOOLEAN MODE)";
    if ($groupWebSAPR->isMember($ses->login())) {
     if (!$myreq) {
      if ($donereq) {
       $reqData->where("rid in ($q_done)");     
       $reqData->_execute();
      } else {
       if ($ses->valueOf('filter.fulltext')) {
        $reqData->contains($ses->valueOf('filter.fulltext'));	//5.0.10
//        $reqData->where("rid in ($q_fulltext)");
	$reqData->_execute();
       } else {
        $reqData->retrive(false);
       }
      }
     } else {
//      $reqData->where("rid in ($q_sapr)");
      $reqData->_from("($q_sapr) as t");
      $reqData->where("$reqtable.rid=t.rid");
      $reqData->_execute();
     }
    } else {
//      $reqData->where("rid in ($q_user)");
      $reqData->where("$q_user");
      $reqData->_execute();
    }
    if (isset($_GET['page'])) {
     $pg		= $_GET['page'];
    } else {
     $pg		= 0;
    }
/*    $tpl->assign(array(	'DISPLAY_PAGE'	=> $_GET['page'],
			'DISPLAY_FROM'	=> $rowFrom,
			'DISPLAY_COUNT'	=> $reqData->count,
			'DISPLAY_TO'	=> $rowFrom + $reqData->count,
			'DISPLAY_NEXT'	=> $_GET['page'] + 1,
			'DISPLAY_PREV'	=> ($_GET['page'] - 1 < 0)?0:$_GET['page'] - 1,
			'FILTER_USER'	=> $ses->valueOf('filter.user')
		));
*/
    $tpl->assign(array(	'DISPLAY_PAGE'	=> $pg,
			'DISPLAY_FROM'	=> $rowFrom,
			'DISPLAY_COUNT'	=> $reqData->count,
			'DISPLAY_TO'	=> $rowFrom + $reqData->count,
			'DISPLAY_NEXT'	=> $pg + 1,
			'DISPLAY_PREV'	=> ($pg - 1 < 0)?0:$pg - 1,
			'FILTER_USER'	=> $ses->valueOf('filter.user')
		));
   if ($u = $cache->valueOf('LOGIN_USERLIST')) {                               
    $tpl->assign('SELECT_LIST', $u);                                             
   } else {                                                                    
    $users                = new User(OUSER_ALL);                               
//    $users->removeDisabled();                                                  
    $users->sortBy('cn');                                                      
    $users->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');             
    $cache->valueOf('LOGIN_USERLIST', $tpl->get_assigned('SELECT_LIST'), USERLIST_TTL);
   }
   if ($u = $cache->valueOf('LOGIN_USERLIST')) {                               
    $tpl->assign('SELECT_LIST', $u);                                             
   } else {                                                                    
    $users                = new User(OUSER_ALL);                               
//    $users->removeDisabled();                                                  
    $users->sortBy('cn');                                                      
    $users->tplComboboxInner('SELECT_LIST', 'cn', 'samaccountname');             
    $cache->valueOf('LOGIN_USERLIST', $tpl->get_assigned('SELECT_LIST'), USERLIST_TTL);
   }


    $reqData->_tpl_tr	= 'tr';
    $tpl->parse('TABLE_HEADER', 'header2');
    $reqData->tplTableInner('CALLS_LIST',                                                                          
//                    Array('rid', 'time', 'targetname', 'username', 'text', 'result'),                                          
                    Array('rid', 'time', 'targetname', 'text', 'result'),                                          
                    Array(false, 'rid', false, false, false),                                              
                    Array(false, '?pid=', false, false, false
			));
    $tpl->parse('BODY', 'list');
   } else {
    $reqActions		= new Request5();
    $reqActions->retrive($rid);
    $reqRoot		= new Request5($rid);
    $reqActions->delete(0);
    $tpl->assign('TITLE', $reqRoot->rid[0].' - Requests - TO');
    if ($groupWebSAPR->isMember($ses->login()) && $reqRoot->result[0] != OREQ_DONE) {
     $tpl->parse('TABLE_HEADER', 'header1');
     $reqActions->tplTableInner('CALLS_LIST',                                                                          
                    Array('rid','time', 'username', 'time2', 'saprname', 'done', 'username2', 'result', 'ORIG_TEXT'),
                    Array(false, false, 'username', false, 'saprname', false, 'username2', false, false),
                    Array(false, '?pid=', 'mailto:', false, 'mailto:', false, 'mailto:', false, false)
		    );
     if ($reqRoot->result[0] == OREQ_DELAY) {
      $tpl->assign('RESULT', '<FONT COLOR=magenta>'.$reqRoot->_actionToString($reqRoot->result[0]).'</FONT>');
     } else {
      $tpl->assign('RESULT', $reqRoot->_actionToString($reqRoot->result[0]));
     }
     $tpl->assign(array('RID'		=> $rid,
			'URL'		=> '?action=save',
			'TARGET'	=> person($reqRoot->targetname[0]),
			'TARGETNAME'	=> $reqRoot->targetname[0],
			'PC'		=> $reqRoot->pcname[0],
			'CURATOR'	=> person($reqRoot->curator[0]),
			'SAPRNAME'	=> person($reqRoot->saprname[0]),
			'TEXT'		=> nl2br(htmlspecialchars($reqRoot->text[0])),
			'TIME'		=> $reqRoot->_timeToString($reqRoot->time[0]),
			'ACTION'	=> $reqRoot->_actionToString($reqRoot->action[0]),
			'CREATOR'	=> person($reqRoot->username[0]),
			'DONE'		=> $reqRoot->_timeToString($reqRoot->done[0]),
			'USERNAME2'	=> $reqRoot->username2[0],
			'TIME2'		=> $reqRoot->_timeToString($reqRoot->time2[0]),
			'COMMENT'	=> nl2br(htmlspecialchars($reqRoot->comment[0])),
			'TAKE_TEXT'	=> $reqRoot->curator[0]?REQ_TAKE_OVER:REQ_TAKE_TEXT,
			'TAKE_ACTION'	=> $reqRoot->curator[0]?'overtake':'curator'
		));
     if (strlen($reqRoot->file[0])) {
      $reqActions->tplLink('FILE', $reqRoot->file[0], '/files/'.$reqRoot->file[0]);
     }
     $users		= $groupWebSAPR->users();
     $users->sortBy('cn');                                               
     $users->tplComboboxInner('USER_LIST', 'cn', 'samaccountname');
     $active		= new Request5();
     $active->orderBy('saprname');
     if (!$groupWebAdmin->isMember($ses->login())) {
      $active->where('saprname=\''.$ses->login().'\'');
     }
     $active->retriveActiveTasks();
     $active->tplTableInner('TASKS_LIST',                                                                          
                    Array('rid', 'time', 'username', 'time2', 'saprname', 'done', 'username2','result'),
                    Array(false, 'pid', 'username', false, 'saprname', false, 'username2', false),                                              
            	    Array(false, '?pid=', 'mailto:', false, 'mailto:', false, 'mailto:', false)
		    );
     $tpl->parse('BODY', 'detales');
    } else {
     $tpl->parse('TABLE_HEADER', 'header1');
     $reqActions->tplTableInner('CALLS_LIST',                                                                          
                    Array('rid', 'time', 'username', 'time2', 'saprname', 'done', 'username2','result', 'ORIG_TEXT'),
                    Array(false, false, 'username', false, 'saprname', false, 'username2', false, false),                                              
                    Array(false, false, 'mailto:', false, 'mailto:', false, 'mailto:', false, false)
		    );
      $tpl->assign(array('RID'		=> $rid,
			'URL'		=> '?action=save',
			'TARGET'	=> person($reqRoot->targetname[0]),
			'TARGETNAME'	=> $reqRoot->targetname[0],
			'PC'		=> $reqRoot->pcname[0],
			'CURATOR'	=> person($reqRoot->curator[0]),
			'SAPRNAME'	=> person($reqRoot->saprname[0]),
			'TEXT'		=> nl2br(htmlspecialchars($reqRoot->text[0])),
			'TIME'		=> $reqRoot->_timeToString($reqRoot->time[0]),
			'ACTION'	=> $reqRoot->_actionToString($reqRoot->action[0]),
			'CREATOR'	=> person($reqRoot->username[0]),
			'DONE'		=> $reqRoot->_timeToString($reqRoot->done[0]),
			'USERNAME2'	=> person($reqRoot->username2[0]),
			'TIME2'		=> $reqRoot->_timeToString($reqRoot->time2[0]),
			'RESULT'	=> $reqRoot->_actionToString($reqRoot->result[0]),
			'COMMENT'	=> nl2br(htmlspecialchars($reqRoot->comment[0]))
		));
     if (strlen($reqRoot->file[0])) {
       $reqActions->tplLink('FILE', $reqRoot->file[0], '/files/'.$reqRoot->file[0]);
     }
     if ($groupWebAdmin->isMember($ses->login()) || $reqRoot->curator[0] == $ses->login()) {
      $tpl->parse('REQ_BUTTONS', 'closed_undo');
      $active		= new Request5();
      $active->orderBy('saprname');
      if (!$groupWebAdmin->isMember($ses->login())) {
       $active->where('saprname=\''.$ses->login().'\'');
      }
      $active->retriveActiveTasks();
      $active->tplTableInner('TASKS_LIST',                                                                          
                    Array('rid', 'time', 'username', 'time2', 'saprname', 'done', 'username2','result'),
                    Array(false, 'pid', 'username', false, 'saprname', false, 'username2', false),                                              
            	    Array(false, '?pid=', 'mailto:', false, 'mailto:', false, 'mailto:', false)
		    );      
     } else {
      $tpl->parse('REQ_BUTTONS', 'closed_comm');
     }
     $tpl->parse('BODY', 'forusers');
    }
   }
  }
 }
$tpl->assign('NAVIGATE', '<A HREF="/2013"><IMG ALT="'.T_HOME.'" SRC="/images/toolbar/house-10.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="request.php"><IMG ALT="'.T_BACK.'" SRC="/images/toolbar/arrowleft.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="javascript:showSettings();"><IMG ALT="'.T_SETTINGS.'" SRC="/images/toolbar/preferences-9.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="wt_help.pdf"><IMG ALT="'.T_HELP.'" SRC="/images/toolbar/lightbulb-9.png" WIDTH=15 HEIGHT=15 BORDER=0></A>');
$tpl->parse('PAGE', "page");
$tpl->FastPrint();

?>