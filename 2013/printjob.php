<?php
//printjob.php v5.0.3

setlocale(LC_ALL, 'ru_RU');
error_reporting(E_ERROR);

require_once('config.php');        
require_once('lib5.php');
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');
require_once(OLIB_PATH.'/class.cache.php');	//5.0.2


$cp		= array();
$cp[]		= time();
$tpl		= &initFastTemplate();
$tpl->define(Array(	'calls'		=> 'body.printjob.tpl',
			'detale'	=> 'body.calls.detale.tpl',
			'pc_table'      => 'body.pc.table_head.tpl',
                        'td_checkbox'   => 'html.td.checkbox.tpl',
			'tr_header'	=> 'html.tr.header.tpl',
			'csv_td'	=> 'csv.td.tpl',
			'csv_tr'	=> 'csv.tr.tpl',
			'csv_body'	=> 'csv.body.tpl'
		));                                                     
		
$ses		= new Session5();
$user		= new User($ses->uid());
$tpl->assign('MESSAGE', $ses->msg());
$cache			= new Cache();				//5.0.2
$ses->getTime();
$ses->getParams(array(	'prnname',
			'username',
			'papername'
		));
$ses->getParams(array(	'sort',
			'det',
			'firstcol'
		),
		true);
$start		= $ses->valueOf('filter.RangeStart');
$interval	= $ses->valueOf('filter.RangeInterval');
$prnname	= $ses->valueOf('filter.prnname');
$username	= $ses->valueOf('filter.username');
$papername	= $ses->valueOf('filter.papername');
$sort		= $ses->valueOf('filter.sort');
$sort		= $sort[0];
$det		= $ses->valueOf('filter.det');
$det		= ($det[0] == 'On')?true:false;

$firstcol	= $ses->valueOf('filter.firstcol');
$firstcol	= ($firstcol !== false)?$firstcol[0]:'printer';	//5.0.2
$superUser	= new Group('Group-TONIPI-Print-Viewer');
if (!$superUser->isMember($ses->login())) {
 $username	= array_intersect($username, $ses->valueOf('filter.targetusers'));
 if (count($username) == 0) {
  $username	= $ses->valueOf('filter.targetusers');
  $ses->valueOf('filter.username', $username);
 }
}
$tpl->assign(Array('INFODATE'	=> $start,
		    'USER_LIST'	=> $phone
		    		    ));
$tst		= new PrintJob5();
$tst->range($start, $interval);
$tpl->assign(Array(	'PRN_NAMES'		=> 'Все',
			'USER_NAMES'		=> 'Все',
			'PAPER_NAMES'		=> 'Все',
			'URL_CLEAR_PRN'		=> '?prnname=',
			'URL_CLEAR_USER'	=> '?username=',
			'URL_CLEAR_PAPER'	=> '?papername=',
			'URL_CLEAR_ALL'		=> '?prnname=&username=&papername=',
			'URL_USERCHOOSE'	=> '?action=userchoose',
			'PRN_SELECTED'		=> '',
			'USER_SELECTED'		=> '',
			'DETALES_CHECKED'	=> ($det?'CHECKED':'')
		    		    ));
				    
if ($prnname !== false) {
 $tpl->clear('PRN_NAMES');
 foreach ($prnname as $item) {
  $tst->tplLink('PRN_NAMES', $item, '?prnname=-'.$item, 'Delete');
  $tpl->parse('PRN_NAMES', '.br');
 }
}
if ($username !== false) {
 $tpl->clear('USER_NAMES');
 foreach ($username as $item) {
  $tst->tplLink('USER_NAMES', $item, '?username=-'.$item, 'Delete');
  $tpl->parse('USER_NAMES', '.br');
 }
}
if ($papername !== false) {
 $tpl->clear('PAPER_NAMES');
 foreach ($papername as $item) {
  $tst->tplLink('PAPER_NAMES', $item, '?papername=-'.$item, 'Delete');
  $tpl->parse('PAPER_NAMES', '.br');
 }
}
if ($firstcol == 'user') {
 $tpl->assign('USER_SELECTED', 'SELECTED');
} else {
 $tpl->assign('PRN_SELECTED', 'SELECTED');
}

if ($sort !== false) {
 if ($sort == 'pages') {
  $tst->orderBy('pages', TRUE);
 } else {
  $tst->orderBy($sort);
 }
} else {
 $tst->orderBy('prnname');
}
//$det = false;
$cp[]		= time();
if (isset($_GET['action']) && $_GET['action'] == 'userchoose') {
 $tpl->assign('TABLE_HEADER', '');                                     
// $tpl->parse('TABLE_HEADER', '.tr_header_3');

 if (($ulist=$cache->valueOf('PRINTJOB_ULIST')) === false) {	//5.0.2
  $tpl->assign(array(	'HEADER_1'		=> 'Имя',
			'HEADER_2'		=> 'Имя',
			'HEADER_3'		=> 'Имя'
		));
  $groups = new WpList(1);
  $groups->where("id_1=''");
  $groups->retrive();
  for ($i = 0; $i < $groups->count; $i++) {                                          
   $group               = new WpPerson();
   $group->where("otdel='".$groups->name[$i]."'");
   $group->retrive();
   $users               = new User5($group->lastname[0].' '.$group->firstname[0], OUSER_CN);
   $users->toMulti();                                                 
   $prevUserCN		= $users->cn[0];
   for ($j = 1; $j < $group->count; $j++) {                   
    $u          = new User5($group->lastname[$j].' '.$group->firstname[$j], OUSER_CN);
    if ($u->count > 0 && $u->cn != $prevUserCN) {
     $u->toMulti();                                                    
     $users->push($u);                                                 
    }
   }                                                                  
   $users->sortBy('cn');                                              
   $ulist	= implode('\',\'username.', $users->samaccountname);
//   $cp[]		= time();
   $users->tpl3row('CALLS_LIST', '<INPUT TYPE="checkbox" onclick="chooseUser(Array(\'username.'.$ulist.'\'));">'.$groups->name[$i]);
//   $cp[]		= time();
  }                                                                   
  $cache->valueOf('PRINTJOB_ULIST', $tpl->get_assigned('CALLS_LIST'), 60);
 } else {				//5.0.2
  $tpl->assign('CALLS_LIST', $ulist);	//5.0.2 
 }					//5.0.2
 if ($start) {                                              
  $tm            = date('d-m-Y', $start);                   
  $tm2           = date('d-m-Y', $start + $interval - 86400);                   
 }
 $tpl->assign(array(	'START_DATE'	=> $tm,
			'END_DATE'	=> $tm2,
			'TITLE'		=> 'Статистика печати - TO'
		));
 $tpl->parse('BODY', 'calls');
 $tpl->parse('PAGE', 'page');
} else {
 //5.0.2
 // $start, $interval, $prnname[], $username[], $paper[], $sort, $def, $firstcol
 $md5time	= md5($start.$interval);
 $gprn		= '';
 $guser		= '';
 $gpaper	= '';
 if ($prnname) {
  foreach ($prnname as $item) {
   $gprn	.= $item;
  }
 }
 if ($username) {
  foreach ($username as $item) {
   $guser	.= $item;
  }
 }
 if ($paper) {
  foreach ($parer as $item) {
   $gpaper	.= $item;
  }
 }
 $isExport = (isset($_GET['action']) && $_GET['action'] == 'export');
 $md5other	= md5($gprn.$guser.$gpaper.$firstcol.$sort.($det?'1':'0').$isExport);
 $cacheKey	= 'PRINTJOB_'.$md5time.$md5other;
 if (($body = $cache->valueOf($cacheKey)) !== false) {
  $tpl->assign('BODY', $body);
 } else {
  if ($isExport) {
   $tst->_tpl_td		= 'csv_td';
   $tst->_tpl_tr		= 'csv_tr';
  }
  $cp[]		= time();
  $tst->retriveByPrinter(($prnname === false || count($prnname) == 0)?false:$prnname, ($username === false || count($username) == 0)?false:$username, $det, $firstcol);
  $cp[]		= time();
  if ($det && $prnname != false && username != false) {
   $tpl->parse('TABLE_HEADER', '.tr_header_7');
   $tpl->assign(array(	'HEADER_1'		=> '',
			'HEADER_2'		=> '',
			'HEADER_3'		=> '',
			'HEADER_4'		=> '',
			'HEADER_5'		=> 'Имя документа',
			'HEADER_6'		=> '',
			'HEADER_7'		=> '',
			'HEADER_8'		=> ''
		));
   $tst->tplLink('HEADER_2', 'Время', '?sort=time');
   $tst->tplLink('HEADER_3', 'Пользователь', '?sort=username');
   $tst->tplLink('HEADER_4', 'Принтер', '?sort=printername');
   $tst->tplLink('HEADER_6', 'Бумага', '?sort=paper');
   $tst->tplLink('HEADER_7', 'Страницы', '?sort=pages');
   if ($isExport) {
    $links	= array(false, false, false, false, false, false, false);
   } else {
    $links	= array(false, 'username', 'prnname', false, false, false, false);
   }
   $tst->tplTableInner('CALLS_LIST',            
		    array('time', 'username', 'prnname', 'docum', 'paper', 'pages', 'bsize'),
		    $links,
		    array(false, '?username=', '?prnname', false, false, false, false));
  } else {
   $tst->tplLink('HEADER_3', 'Бумага', '?sort=paper');
   $tst->tplLink('HEADER_4', 'Страницы', '?sort=pages');
   if ($firstcol == 'user') {
    $tpl->parse('TABLE_HEADER', '.tr_checkbox_header_4');
    $tst->tplLink('HEADER_2', 'Принтер', '?sort=prnname');
    $tst->tplLink('HEADER_1', 'Потльзователь', '?sort=username');
    if ($isExport) {
     $links	= array(false, false, false, false);
    } else {
     $links	= array('username', 'prnname', false, false);
    }
    $tst->tplTableInnerFast('CALLS_LIST',            
		    array('username', 'prnname', 'paper', 'pages'),
		    $links,
		    array('?username=', '?prnname=', false, false));
   } else {
    $tpl->parse('TABLE_HEADER', '.tr_checkbox_header_4');
    $tst->tplLink('HEADER_1', 'Принтер', '?sort=prnname');
    $tst->tplLink('HEADER_2', 'Пользователь', '?sort=username');
    if ($isExport) {
     $links	= array(false, false, false, false);
    } else {
     $links	= array('prnname', 'username', false, false);
    }
    $tst->tplTableInner('CALLS_LIST',            
		    array('prnname', 'username', 'paper', 'pages'),
		    $links,
		    array('?prnname=', '?username=', false, false));
   }
  }
  if ($start) {                                              
   $tm            = date('d-m-Y', $start);                   
   $tm2           = date('d-m-Y', $start + $interval - 86400);                   
  }
  if ($isExport) {
   header('Content-type: text/plain; charset=windows-1251');
   header('Content-Disposition: inline; filename="'.$cacheKey.'.csv"');
   $tpl->parse('PAGE', 'csv_body');
   $tpl->FastPrint();
   exit(0);
  } else {
   $a4		= 0;
   $a3		= 0;
   $a2		= 0;
   $a1		= 0;
   $a0		= 0;
   $default	= 0;
   $other		= 0;
   for ($i = 0; $i < $tst->count; $i++) {
    switch ($tst->paper[$i]) {
    case 'A4':
     $a4		+= $tst->pages[$i];
    break;
    case 'A3':
     $a3		+= $tst->pages[$i];
    break;
    case 'A2':
     $a2		+= $tst->pages[$i];
    break;
    case 'A1':
     $a1		+= $tst->pages[$i];
    break;
    case 'A0':
     $a0		+= $tst->pages[$i];
    break;
    case 'Default':
     $default	+= $tst->pages[$i];
    break;
    default:
     $other	+= $tst->pages[$i];
    }
   }
   $tpl->assign(array(	'START_DATE'	=> $tm,
			'END_DATE'	=> $tm2,
			'TITLE'		=> 'Статистика печати - TO',                  
			'A4'		=> $a4,
			'A3'		=> $a3,
			'A2'		=> $a2,
			'A1'		=> $a1,
			'A0'		=> $a0,
			'DEFAULT'	=> $default,
			'OTHER'		=> $other
		));
   $tpl->parse('BODY', 'calls');
   $cache->valueOf($cacheKey, $tpl->get_assigned('BODY'), 300);
  }
 }
 $tpl->parse('PAGE', 'page');
}
$tpl->FastPrint();
?>