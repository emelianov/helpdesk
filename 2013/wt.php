<?php
//wt.php v2013.1

setlocale(LC_ALL, 'ru_RU');

require_once('config.php');
require_once(OLIB_PATH.'/class.ad.php');
require_once('lib6.php');
require_once(OLIB_PATH.'/class.session.php');     
require_once(OLIB_PATH.'/class.process.php');     

$tpl		= &initFastTemplate();
$tpl->define(array(     'pc_table'	=> 'body.pc.table_head.tpl',
			'pc'		=> 'body.pc.tpl',
			'process'	=> 'body.pc.process.tpl',
			'floating'	=> 'html.wt.floating.tpl',
			'settings'	=> 'html.wt.settings.tpl'
	    ));

$ses		= new Session();


$acl		= array();
$acl[]		= array(573, 'Emelianov_AM', true);
//$acl[]		= array(63563, 'Emelianov_AM',true);
//$acl[]		= array(4, 'Utanov_AE', true);
$acl[]		= array(601,	'Kondakov_AP', true);
$acl[]		= array(250,	'Kondakov_AP', true);
$acl[]		= array(1,	'Kondakov_AP', true);
$acl[]		= array(557,	'Kondakov_AP', true);
$acl[]		= array(558,	'Kondakov_AP', true);
$acl[]		= array(117,	'Kondakov_AP', true);
$acl[]		= array(573,	'Hodanovich_SM', true);
$acl[]		= array(566,	'Grishina_OB', true);
$acl[]		= array(567,	'Fatihov_AM', true);
$acl[]		= array(574,	'Meteleva_SA', true);
$acl[]		= array(117,	'Senatov_VA', true);
$acl[]		= array(118,	'Senatov_VA', true);
$acl[]		= array(624,	'Senatov_VA', true);
$acl[]		= array(119,	'Senatov_VA', true);
$acl[]		= array(120,	'Senatov_VA', true);
$acl[]		= array(122,	'Senatov_VA', true);
$acl[]		= array(124,	'Senatov_VA', true);
$acl[]		= array(125,	'Senatov_VA', true);
$acl[]		= array(128,	'Senatov_VA', true);
$acl[]		= array(602,	'Senatov_VA', true);
$acl[]		= array(129,	'Senatov_VA', true);
$acl[]		= array(131,	'Senatov_VA', true);
$acl[]		= array(538,	'Senatov_VA', true);
$acl[]		= array(130,	'Senatov_VA', true);
$acl[]		= array(133,	'Nelubina_LA', true);
$acl[]		= array(135,	'Panov_SI', true);
$acl[]		= array(520,	'Panov_SI', true);
$acl[]		= array(136,	'Panov_SI', true);

$title;
$vizaEdit;

function canApprove($ou, $u) {
//$ou - OU ID
//$u user Login (Lastname_FM)
 global $acl;
// if ($u == 'Emelianov_AM') return true;
 foreach ($acl as $a)
  if ($a[0] == $ou && $a[1] == $u)
   return $a[2];
 $dep		= new WpList(1);
 $dep->where("id=$ou");
 $dep->retrive();
 if ($dep->count > 0) {
  $par		= new WpList(1);
  $par->where('id='.$dep->id_1[0]);
  $par->retrive();
  for ($i=0;$i < $par->count; $i++){
   if (canApprove($par->id[$i], $u))
    return true;
  }
 }
 $acl[]		= array($ou, $u, false);
 return false;
}


// Create acl
 $u		= $ses->login();
 $adu		= new User5($ses->login());
 $t		= $adu->employeeid;
 $p	= new WpPerson();
 $p->where("SAPR_VIEW_people.note6='$t'");
 $p->retrive();
 if ($p->count > 0 && in_array($p->prior_dolg[0], array(10,16,25,26,35,36)))
   $acl[] = array(trim($p->note1[0]), $u, true);
 $userBehalf	= new WPBehalf();
 $userBehalf->where('tabio="'.$p->note6[0].'" and typeio=1');
 $userBehalf->retrive();
 if ($userBehalf->count > 0) {
  for ($i = 0; $i < $userBehalf->count; $i++) {
   $buser	= new User5($userBehalf->tab[$i], OUSER_TAB);
   $p1	= new WpPerson();
   $p1->where("SAPR_VIEW_people.note6='".$userBehalf->tab[$i]."'");
   $p1->retrive();
   if ($p1->count > 0 && in_array($p1->prior_dolg[0], array(10,16,25,26,35,36)))
    $acl[] = array(trim($p1->note1[0]), $buser->samaccountname, true);
   for ($j = 0; $j < count($acl); $j++) {
    if ($acl[$j][1] == $buser->samaccountname)
     $acl[$j][1]	= $ses->login();
   }
  }
 }

// Process date/time from URL
 $now		= getDate();                   
 $start		= mktime(0,0,0,$now['mon'],$now['mday']-2);
 if (isset($_GET['date'])) {
  list($day, $mon, $year)		= split('[/.-]',$_GET['date']);
  $start	= mktime(0,0,0,$mon,$day,$year);
 }
 $int		= 86400;
 if (isset($_GET['interval'])) {
  switch ($_GET['interval']) {
   case 'month':
    $ds		= mktime(0,0,0,$mon + 1,$day,$year);
    $int	= $ds - $start - 86400;
    break;
   case 'week':
    $int	= 86400 * 7;
    break;
   case 'year':
    $ds		= mktime(0,0,0,$mon,$day,$year + 1);
    $int	= $ds - $start;
    break;
   default:
    $int	= $_GET['interval'];
  }
 }
//--------------------------------------------------------------------

// Process save/aprove from URL and POST
if (isset($_GET['action'])) {
 if ($_GET['action'] == 'save') {
  if (isset($_POST['editID']) && isset($_POST['editText']) && strlen($_POST['editText']) > 0){
   $obj		= new WPLeave2013($_POST['editID']);
   $obj->retrive();
   $curUser	= new User5($ses->login());
   if ($obj->count = 1) {
    $person	= new WpPerson();
    $person->where('note6="'.$obj->tabel[0].'"');
    $person->retrive();
    if (($curUser->employeeid == $obj->tabel[0]) || canApprove($person->note1[0], $ses->login())) {
     $obj->txtotpusk[0] = $_POST['editText'];
      $obj->updateText();
    } else $ses->msg('В доступе отказано');
   } else $ses->msg('Ошибка базы данных');
  } else $ses->msg('Ошибка сервера');
 } elseif ($_GET['action'] == 'approve') {
  if (isset($_GET['id']) && isset($_GET['approve'])) {
   $obj	= new WPLeave2013($_GET['id']);
   $obj->retrive();
   $curUser	= new User5($ses->login());
   if ($obj->count = 1) {
    $person	= new WpPerson();
    $person->where('note6="'.$obj->tabel[0].'"');
    $person->retrive();
    if (canApprove($person->note1[0], $ses->login())) {
     $obj->vizafio[0] = $ses->login();
     $obj->viza[0] = $_GET['approve'];
     $obj->updateViza();
    } else $ses->msg('В доступе отказано');
   } else $ses->msg('Ошибка базы данных');
  } else $ses->msg('Ошибка сервера');
 } elseif ($_GET['action'] == 'behalf') {
  $activeBehalf = new WPBehalf();
  $tab		= $p->note6[0];
  $activeBehalf->where("tab=\"$tab\" and typeIO=1");
  $activeBehalf->retrive();
//  if ($_POST['io'] == 0) {
   if ($activeBehalf->count > 0) {
    $activeBehalf->erase();
   }
//  } else {
   $newBehalf		= new WPBehalf();
   $newBehalf->tab[0]	= $p->note6[0];
   $newBehalf->tabio[0]	= $_POST['io'];
   $newBehalf->typeio[0]= 1;
   $newBehalf->count	= 1;
   $newBehalf->insert();
//  }
 }
}
//--------------------------------------------------------------------

$user		= new WpLeave2013();
$where		= '';
$users		= new WpPerson();
if (isset($_GET['ou'])) {
 $ous		= explode(',',$_GET['ou']);
 foreach ($ous as $ou) {
  $ouu		= trim($ou);
//  $ou		= $_GET['ou'];
  if (canApprove($ou, $ses->login())) {
   $oup		= false;
   $oupp	= false;
   if ($ou != '*') {
    if ($where != '')
     $where .= ' OR ';
    $where	.= "SAPR_VIEW_people.note1='$ou'";
    $ouu	= new WpList();
    $ouu->where("id_1='$ou'");
    $ouu->retrive();
    if ($ouu->id_1 != 0) {
     foreach ($ouu->id as $ouc) {
      $where	.= " OR SAPR_VIEW_people.note1='$ouc'";
      $ouw	= new WpList();
      $ouw->where("id_1='$ouc'");
      $ouw->retrive();
      foreach ($ouw->id as $oud)
       if ($ouu->id_1 != 0)
        $where	.= " OR SAPR_VIEW_people.note1='$oud'";
     }
    }
   }
  }
 }
 $where_for_behalf = $where;
} elseif (isset($_GET['tab'])) {
 $tabs		= explode(',',$_GET['tab']);
 foreach ($tabs as $tab) {
  $tab		= trim($tab);
  if (is_numeric($tab)) {
   $t		= $tab;
  } else {
   $adUser	= new User5($tab);
   $t		= $adUser->employeeid;
  }
  $u		= new User5($ses->login());
  $p		= new WpPerson();
  $p->where("SAPR_VIEW_people.note6='$t'");
  $p->retrive();
  $pu		= ($p->count=1)?$p->note1[0]:0;
  if (canApprove($pu, $ses->login()) || canApprove($t, $ses->login()))
   $user->vizaEdit	= true;
  if ($u->employeeid == $t || canApprove($pu, $ses->login()) || canApprove($t, $ses->login())) {
   if ($where != '')
    $where .= ' OR ';
   $where	.= "SAPR_VIEW_people.note6='$t'";
  }
 }
}
 if ($where != ''){
  $users->where("($where)");
 } else {
  $loc		= '';
  foreach ($acl as $ac) {
   if ($ac[1] == $ses->login())
    if ($loc == '')
     $loc	= 'ou='.$ac[0];
    else
     $loc	.= ','.$ac[0];
  }
  if ($loc != '') {
   header('Location: ?'.$loc.'&date='.date('d-m-Y',$start).'&interval='.$int);
   exit();
  }
  $u		= new User5($ses->login());
  $users->where('SAPR_VIEW_people.note6='.$u->employeeid);
 }
 $users->retrive();

 $tpl->assign('NAVIGATE', '<A HREF="/2013"><IMG ALT="'.T_HOME.'" SRC="/images/toolbar/house-10.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="?date='.date('d-m-Y',$start).'&interval='.$int.'"><IMG ALT="'.T_BACK.'" SRC="/images/toolbar/arrowleft.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="javascript:showSettings();"><IMG ALT="'.T_SETTINGS.'" SRC="/images/toolbar/preferences-9.png" WIDTH=15 HEIGHT=15 BORDER=0></A>&nbsp;<A HREF="wt_help.pdf"><IMG ALT="'.T_HELP.'" SRC="/images/toolbar/lightbulb-9.png" WIDTH=15 HEIGHT=15 BORDER=0></A>');
 $where		= '';
 for ($i = 0; $i < $users->count; $i++) {
  if ($where != '')	$where .= ' OR ';
  $where	.= "tabel='".$users->note6[$i]."'";
 }
 $user->where("($where)");
 $user->where('viza <> 1');
 $user->timeRange($start, $int);
 $user->orderBy('fio');
 $user->orderBy('dFrom');
 $user->orderBy('tFrom');
 $user->retrive();
// echo $user->count;
// if (false) {
 if ($user->count > 0) {
  if (isset($_GET['tab'])) {
   $tab	= $_GET['tab'];
//   $user->vizaEdit = $vizaEdit;
  } else
   $tab	= false;
  $user->urlSuffix = 'date='.date('d-m-Y',$start).'&interval='.$int;
  if (isset($_GET['tab']))
   $user->urlSuffix .= '&tab='.$_GET['tab'];
  $tpl->parse('TABLE_TEXT', 'wt_header');
   $user->tplTableInner('TABLE_TEXT', 
	array('id', 'fio', 'dfrom', 'tfrom', 'tto', 'txtotpusk', 'viza'), 
	array(false, 'tabel', false, false, false, false, false), 
	array(false, '?date='.date('d-m-Y',$start).'&interval='.$int.'&tab=', false, false, false, false, false),
	array('WIDTH=50px', 'WIDTH=420px', 'WIDTH=100px', 'WIDTH=80px', 'WIDTH=50px', 'WIDTH=50%', 'WIDTH=0%')
	);
  if ($p->prior_dolg[0] <= 36) {
   $behalf	=  new WpPerson();
   $behalf->where('note1='.$p->note1[0]);
   $dep		= new WpList(1);
   $dep->where('id_1='.$p->note1[0]);
   $dep->retrive();
   if ($dep->count > 0) {
    $behalf->where('note1='.$dep->id[0]);
    $dep1	= new WpList(1);
    $dep1->where('id_1='.$dep->id[0]);
    $dep1->retrive();
    if ($dep1->count >0) {
     $behalf->where('note1='.$dep1->id[0]);
    }

    if ($p-prior_dolg < 35) {
     $behalf->where('prior_dolg < 36');
    } 
   }
   $behalf->retrive();
   $behalf->sortBy('fio');
   $behalf->tplComboboxInner('IOLIST', 'fio', 'note6');
  }
  $activeBehalf = new WPBehalf();
  $tab		= $p->note6[0];
  $activeBehalf->where("tab=\"$tab\" and typeIO=1");
  $activeBehalf->retrive();
  if ($activeBehalf->count > 0) {
   $tpl->assign('TABIO', $activeBehalf->tabio[0]);
  } else
   $tpl->assign('TABIO', 0);
  $activeio	= '';
  foreach ($userBehalf->tab as $f) {
   $r		= new WpPerson();
   $r->where("SAPR_VIEW_people.note6='$f'");
   $r->retrive();
   if ($r->count > 0)
    $activeio	.= '<BR>'.$r->fio[0];
  }
  $tpl->assign('ACTIVEIO', $activeio);
  $tpl->assign('URLSUFFIX', $user->urlSuffix);
  $tpl->parse('BODYSTART', '.floating');
  $tpl->parse('BODYSTART', '.settings');
  $tpl->parse('BODY', 'table');
 } else {
  $tpl->assign('BODY', 'Нет данных в данном диапазоне');
 }
$tpl->assign('MESSAGE', $ses->msg());
$tpl->parse('PAGE', 'page');
$tpl->FastPrint();
?>