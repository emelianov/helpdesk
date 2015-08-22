<?php
//login.php v5.0.5
//
// Emelianov's HelpDesk
// (c)2006-2014 Alexander Emelianov (a.m.emelianov@gmail.com)
//

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');        
require_once('lib5.php');
require_once(OLIB_PATH.'/class.session.php');     
require_once(OLIB_PATH.'/class.cache.php');     
define('USER_NAME',	'REMOTE_USER');

$tpl		= &initFastTemplate();

$cache		= new Cache();
$ses		= new Session(true);
$tpl->assign('MESSAGE', $ses->msg());
if ($ses->url()) {
 $target_url	= $ses->url();
} else {
 $target_url	= '/';
}
if (isset($_POST['USERNAME']) || isset($_SERVER[USER_NAME])) {
 $ses->dispose('uid');
 $usr		= new User5(isset($_POST['USERNAME'])?$_POST['USERNAME']:$_SERVER[USER_NAME]);
 if ($usr->count > 0) {
  if (isset($_SERVER[USER_NAME]) || (($_POST['PASS']) && strlen($_POST['PASS']) > 0 && $usr->checkPass($_POST['PASS']))) {
   $ses->uid($usr->samaccountname);
   $ses->login($usr->samaccountname);
   $ses->valueOf('cn', $usr->cn);
   $tar		= array();
   if ($usr->directreports) {
    $tar	= $usr->fullName2account($usr->directreports);
   } else {
    $tar[]	= $usr->samaccountname;
   }
   $ses->valueOf('filter.targetusers', $tar);
  } else {
   $ses->msg('В доступе отказано: неверное имя пользователя или пароль.');
   $target_url	= LOGIN_URL;
  }
 } else {
  $ses->msg('В доступе отказано: неверное имя пользователя или пароль.');
  $target_url	= LOGIN_URL;
 }
 if (($i	= strpos($target_url, '?')) !== false) {
  $target_url	= substr($target_url, 0, $i).''.substr($target_url, $i);
 } else {
  if ($target_url != LOGIN_URL) {
   $target_url	.= '';
  }
 }
 header("Location: $target_url");
 $tpl->assign('BODY', "Если браузер не перешел автоматически нажмите ссылку ниже:<BR><A HREF='$target_url'>Предыдущая страница</A>");
} else {
 if ($u = $cache->valueOf('LOGIN_USERLIST')) {
  $tpl->assign('USER_LIST', $u);
 } else {
  $users		= new User(OUSER_ALL);
  $users->removeDisabled();
  $users->sortBy('cn');
  $users->tplComboboxInner('USER_LIST', 'cn', 'samaccountname');
  $cache->valueOf('LOGIN_USERLIST', $tpl->get_assigned('USER_LIST'), USERLIST_TTL);
  $tpl->assign('URL', 'login.php');
 }
 $tpl->parse('BODY', 'body');
}
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>