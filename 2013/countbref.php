<?php
//cid.php v5.0.0

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');        
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');
require_once('lib5.php');


class ReqB extends Request {
// function __construct() {
//  parent::__construct();
//  $this->_addField()
// }
 function _usernameToString ($name) {
  $u		= new User($name);
//  $p		= new WpPerson();
//  $p->where('note6='.$u->employeeid);
//  $p->retrive();
  return $u->cn;
 }
 function _FORToString($name) {
  $u		= new User($name);
  $p		= new WpPerson();
  $p->where('note6='.$u->employeeid);
  $p->retrive();
  return $p->otdel[0];
 }
 function tplTableInner($a, $b, $c, $d) {
  $this->DONEBY	= $this->rid;
  $this->FOR	= $this->username;
  parent::tplTableInner($a, $b, $c, $d);
 }
 function _DONEBYToString($rid) {
  $s		= '';
  $act		= new Request();
  $act->where("pid=$rid");
  $act->_execute();
  for($i=0; $i<$act->count; $i++) {
   if ($i > 0)
    $s		.= ', ';
   $u		= new User($act->saprname[$i]);
   $s		.= $u->cn;
  }
  return $s;
 }
}

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
$users		= new ReqB();
$users->findBy();
$users->findBy('pid = 0');
$users->range(mktime(0,0,0,10,1,2013),86400*31*3);
//$users->findBy('saprname="Korzhov_OV"');
$users->_execute();
//echo $users->count;
$users->tplTableInner('TABLE_TEXT',
			array('rid',	'time',	'done',	'FOR',	'username',	'DONEBY',	'text'),
			array(false,	false,	false,	false,	false,		false,		false),
			array(false,	false,	false,	false,	false,		false,		false),
			array(false,	false,	false,	false,	false,		false,		false)
		);
$tpl->parse('BODY', 'table');
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>