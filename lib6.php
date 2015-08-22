<?php
//lib5.php v5.1.0
//
// Emelianov's HelpDesk
// (c)2006-2014 Alexander Emelianov (a.m.emelianov@gmail.com)
//

require_once('config.php');        
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.printjob.php');        
require_once(OLIB_PATH.'/class.session.php');     
require_once(OLIB_PATH.'/class.req.php');
require_once(OLIB_PATH.'/class.wp2.php');

if (!defined('OREQ5_BREF')) {		//5.0.7
 define('OREQ5_BREF',	40);		//5.0.6
}

class WPPerson5 extends WPPerson {
 function _lastnameToString($t) {
  return '&nbsp;&nbsp;&nbsp;&nbsp;'.$t;
 }
 function _tplClearDups($tds, $prevtds, $i) {
  if ($tds[0] == $prevtds[0] && $tds[1] == $prevtds[1] && $i < 3) {
   return true;
  } else {
   return false;
  }
 }
 function _HTMLPHOTOtoString($s) {
  $s		= file_exists(PHOTOPATH.'/'.$s.'.jpg')?$s:PHOTOABSENT;
  return '<IMAGE SRC="/van/photo/'.$s.'.jpg" WIDTH=30 HEIGHT=40>';
 }
}

class WpList5 extends WPlist {
 function WpList5($id_0=false) {
  $this->WpList($id_0);
  $this->_tpl_td	= 'tr_request4';
 }
}

global  $init_tpl;               
$init_tpl[]     = 'initRequest5';
$init_tpl[]     = 'initWPList5';
                                 
function initRequest5() {        
 global $base_tpl;               
 $base_tpl->define(	array(	'tr_request'		=> 'html.tr.radio.tpl',
				'tr_green'		=> 'html.tr.green.tpl',
				'tr_red'		=> 'html.tr.red.tpl',
				'tr_radio_green'	=> 'html.tr.radio.green.tpl',
				'tr_radio_red'		=> 'html.tr.radio.red.tpl',
				'tr_radio_light'	=> 'html.tr.radio.light.tpl',
				'tr_purple'		=> 'html.tr.purple.tpl',
				'tr_checkbox'		=> 'html.tr.checkbox.tpl',
				'wt_header'		=> 'html.wt.table.head.tpl'
		));
}

function initWPList5() {        
 global $base_tpl;               
 $base_tpl->define(	array(	'tr_request4'	=> 'html.td.2.tpl'
		));
}

class WpLeave2013 extends WpLeave {
 var $vizaEdit	= false;
 var $urlSuffix = '';
 function updateText() {
  $this->_fieldsUpdate = array('txtotpusk');
  return parent::update();
 }
 function updateViza() {
  $this->_fieldsUpdate = array('viza', 'vizafio');
  return parent::update();
 }
 function _vizatoString($val) {			//0 - Unset, 1 - OK (otpusk , komand), 2 - BOSS - ok, 3 - BOSS - fail
  return '';
 }
 function _txtotpusktoString($val) {
  return '';
 }
 function tplTableRow($var, $tds) {
  $edit		= $this->vizaEdit?'':'DISABLED';
  $s0		= $tds[6]['value']==0?'SELECTED':'';
  $s2		= $tds[6]['value']==2?'SELECTED':'';
  $s3		= $tds[6]['value']==3?'SELECTED':'';
  $id		= $tds[0]['value'];
  $fio		= $tds[1]['value'];
  $date		= $this->_dfromtoString($tds[2]['value']);
  $timeFrom	= $this->_tfromtoString($tds[3]['value']);
  $timeTo	= $this->_ttotoString($tds[4]['value']);
  $reason	= $tds[5]['value'];
  $viza		= $tds[6]['value'];
  $saveTr		= $this->_tpl_tr;
  $tds[0]['link'] = "mailto:$fio?subject=$id,$date&body=---\n$reason\n---";
  if ($tds[6]['value'] == 0) {
   if ($tds[5]['value'])
    $this->_tpl_tr = 'tr_purple';
  } elseif ($tds[6]['value'] == 2)
   $this->_tpl_tr = 'tr_green';
  elseif ($tds[6]['value'] == 3)
   $this->_tpl_tr = 'tr_red';
  $e = (strlen($reason) > 0)?$edit:'DISABLED';
  $tds[6]['text'] = "<SELECT name=\"viza$id\" $e onchange=\"approve($id,this.options[this.selectedIndex].value);\"><OPTION value=0 $s0>Нет отметки</OPTION><OPTION value=2 $s2>Уважительная</OPTION><OPTION value=3 $s3>Неуважительная</OPTION></SELECT>";
  $tds[6]['link'] = false;
  
  if ($viza == 0) {
   $noReason	= ($this->vizaEdit)?'Причина не указана':'Укажите причину';
   $tds[5]['text'] = "<A HREF=\"javascript:fillEdit($id, '$date', '$timeFrom', '$timeTo', '$reason');showEdit();\">".($tds[5]['value']?$tds[5]['value']:$noReason)."</A>";
  } else
   $tds[5]['text'] = $tds[5]['value'];
  $tds[5]['link'] = false;
  parent::tplTableRow($var, $tds);
  $this->_tpl_tr	= $saveTr;
 }
}

class RequestClass5 extends RequestClass {	//5.1.0
 var $cids		= 0;
 function __construct($id=false) {
  parent::__construct($id);
  $this->_tpl_tr	= 'tr_checkbox';
 }
 function tplTableRow($var, $tds) {
  $this->_tpl->assign('TR_CHECKBOX_TEXT', '');
  $this->_tpl->assign('TR_CHECKBOX_VALUE', $tds[1]['value']);
  if (((int)$this->cids & (int)$tds[1]['value']) != 0) {
//echo (int)$this->cids.' - '.(int)$tds[1]['value'].'<BR>';
   $this->_tpl->assign('TR_CHECKBOX_EXTRA', 'CHECKED');
  } else {
   $this->_tpl->assign('TR_CHECKBOX_EXTRA', '');
  }
  parent::tplTableRow($var, $tds);
 }
}
class Request5 extends Request {
 var	$brefLen		= OREQ5_BREF;	//5.0.6
 function __construct($rid=false) {
  parent::__construct($rid);
  $this->_tpl_tr	= 'tr_request';
 }
 function tplTableRow($var, $tds) {
  $this->_tpl->assign('TR_RADIO_TEXT', '');
  $this->_tpl->assign('TR_RADIO_VALUE', $tds[0]['value']);
  $saveTr		= $this->_tpl_tr;
  if ($this->_tpl_tr == 'tr_request') {
   $action			= $tds[7]['value'];
   $red				= 'tr_radio_red';
   $green			= 'tr_radio_green';
  } else {
   $action			= $tds[count($tds)-1]['value'];
   $red				= 'tr_red';
   $green			= 'tr_green';
   $purple			= 'tr_purple';
  }
  switch ($action) {
  case OREQ_PROCESS:
   $this->_tpl_tr		= $green;
  break;
  case OREQ_WAIT:
   $this->_tpl_tr		= $red;
  break;
  case OREQ_DELAY:
   $this->_tpl_tr		= $purple;
  break;
  }
  parent::tplTableRow($var, $tds);
  $this->_tpl_tr	= $saveTr;
 }
 function tplTableInner($var, $textFields, $linkFields, $linkPrefixes) {
//  $this->ORIG_TEXT	= $this->text;
  $this->ORIG_TEXT	= $this->rid;
  $this->ORIG_COMM	= $this->text;
  $this->ORIG_BUTT	= $this->rid;
  parent::tplTableInner($var, $textFields, $linkFields, $linkPrefixes);
 }
 function _textToString($t) {
  return htmlspecialchars(substr($t, 0, $this->brefLen));	//5.0.6
 }
// function _timeToString($t) {
//  return date('d-m-y_H:i');	//5.0.6
// }
 function _ORIG_COMMtoString($s) {
  return '</TD></TR><TR><TD></TD><TD></TD><TD COLSPAN=10>'.nl2br($s);
 }
 function _ORIG_BUTTtoString($s) {
  return '</TD><TD ROWSPAN=3>
  <TABLE CLASS="button" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORDER=2>
   <TR><TD><A HREF="reqclass.php?pid='.$s.'">Comment</A></TD></TR>
   <TR><TD><A HREF="reqclass.php?rid='.$s.'">Classify</A></TD></TD></TR>
   <TR><TD><A HREF="reqclass.php?pid='.$s.'">Take</A></TD></TD></TR>
   <TR><TD><A HREF="reqclass.php?pid='.$s.'">Finish</A></TD></TD></TR>
   <TR><TD><A HREF="reqclass.php?pid='.$s.'">Reject</A></TD></TD></TR>
  </TABLE>';
 }
 function _ORIG_TEXTtoString($s) {
  $comm			= new Note(O_REQUEST, $s);
  error_log($s);
  $comm->_tpl->clear('COMM_TABLE');
  if ($comm->count > 0) {
   $comm->tplTableInner('COMM_TABLE',
			array(false, false, 'created',  'owner',           'content'),
			array(false, false, false,      'owner',           false),
			array(false, false, false,      'person.php?tab=', false),
			array('',    '',    'WIDTH=0%', 'WIDTH=0%',        'WIDTH=50% COLSPAN=10')
			);
  } else {
   $comm->_tpl->assign('COMM_TABLE','');
  }
  return '</TD></TR>'.$comm->_tpl->get_assigned('COMM_TABLE').'<TR><TD>';
 }
 function retriveActiveTasks($rid=false) {
  if ($rid) {
   $this->where("pid=$rid");
  } else {
//   $this->where("(pid IS NOT NULL AND pid <> 0)");
   $this->where("(pid <> 0)");
  }
  $this->where("(result=".OREQ_PROCESS." OR result=".OREQ_WAIT.")");
  $this->_execute();
 }
 function _cidtoString($s) {
  $i	= $s;
  $b	= '';
  while ($i != 0) {
   $b = ' '.($i %2).$b;
   $i	= (int)floor($i/2);
  }
  $b	= str_repeat('0 ', 32-(strlen($b) / 2)).$b;
  return $b;
 }
}

class User5 extends User {
 function __construct($uid, $uidType=OUSER_LOGIN) {
  parent::__construct($uid, $uidType);
 }
 function tpl3row($name, $header) {
  $tpl		= & $this->_tpl;
  $tpl->assign('TD_CHECKBOX_TEXT', '');
  $tpl->assign('TD_TEXT', $header);
  $tpl->parse('TR_TEXT', '.td');
  $tpl->assign('TD_TEXT', '');
  $tpl->parse('TR_TEXT', '.td');
  $tpl->assign('TD_TEXT', '');
  $tpl->parse('TR_TEXT', '.td'); 
  $tpl->parse($name, '.tr_header');
  $tpl->clear('TR_TEXT');
  for ($i = 0; $i < $this->count;) {
   for ($j = 0; $j < 3; $j++,$i++) {
    if (isset($this->cn[$i])) {
     if ($this->useraccountcontrol[$i] & 2) {
      $tpl->assign('TD_TEXT', '<FONT COLOR="gray">'.$this->cn[$i].'</FONT>');
     } else {
      $tpl->assign('TD_TEXT', $this->cn[$i]);
     }
     $tpl->assign('TD_CHECKBOX_VALUE', 'username.'.$this->samaccountname[$i]);
     $tpl->parse('TR_TEXT', '.td_checkbox');
    } else {
     $tpl->assign('TD_TEXT', '');
     $tpl->parse('TR_TEXT', '.td');
    }
   }
   $tpl->clear('TR_TEXT');
   $tpl->parse($name, '.tr');
  } 
 }
 function fullName2account($list) {
  $tmp		= array();
  foreach ($list as $item) {
   $u		= new User($item, OUSER_FULLNAME);
   $tmp[]	= $u->samaccountname;
  }
  return $tmp;
 }
 function _execute($a=NULL) {
  parent::_execute($a);
  for ($i = 0; $i < $this->count; $i++) {
   if ($this->samaccountname[$i] == 'Nelyuina_VA') {
    $this->employeeid[$i] = '63533';
   }
  }
 }
}

class PrintJob5 extends PrintJob {
 function PrintJob5() {
  $this->PrintJob();
 }
 function __usernametoString($t) {
  if (strlen($t) > 0) {
   $u		= new User($t);
   if (strlen($u->cn) > 0) {
    return $u->cn;
   } else {
    return $t;
   }
  }
 }
 function retriveByPrinter($prnname=false, $username=false, $det=false, $firstcol=false){
  if ($prnname !== false) {
   if (is_array($prnname)) {
    $tmp	= '';
    foreach ($prnname as $item) {
     if ($tmp != '') {
      $tmp	.= ' OR ';
     }
     $tmp	.= "prnname='$item'";
    }
    $this->findBy("($tmp)");
   } else {
    $this->findBy("prnname='$prnname'");
   }
   $this->groupBy('prnname');
  }
  if ($username !== false) {
   if (is_array($username)) {
    $tmp	= '';
    foreach ($username as $item) {
     if ($tmp != '') {
      $tmp	.= ' OR ';
     }
     $tmp	.= "username='$item'";
    }
    $this->findBy("($tmp)");
   } else {
    $this->findBy("username='$username'");
   }
   $this->groupBy('username');
  }
 
  if ($det !== false && $prnname != false && $username != false) {
   $this->_query	= '
	    SELECT	time, prnname, username, paper, pages, docum
	    FROM	printjobs
	';
   $this->groupBy();
  } else {
   if ($prnname === false && $username === false) {
    if ($firstcol == 'printer') {
     $this->groupBy('prnname');
     $this->groupBy('paper');
     $this->_query       = '
	SELECT      prnname, paper, SUM(pages) AS pages
	FROM                printjobs
	';
    } else {
     $this->groupBy('username');
     $this->groupBy('paper');
     $this->_query       = '
	SELECT      username, paper, SUM(pages) AS pages
	FROM                printjobs
	';

    }
   } else {
    $this->groupBy('prnname');
    $this->groupBy('username');
    $this->groupBy('paper');
    $this->_query       = '
	SELECT      prnname, username, paper, SUM(pages) AS pages
	FROM                printjobs
	';
   }
  }
  $this->_execute();
//echo $prnname[1].'<BR>'.$this->_query;
 }
 function retriveByUser($username=false) {
 }
}

class Session5 extends Session {
 var	$start;
 var	$interval;
 function Session5() {
  $this->Session();
 }
 function getTime() {
  if (isset($_GET['start'])) {                           
   $start		= $_GET['start'];                      
   if (isset($_GET['interval'])) {                       
    $interval		= $_GET['interval'];                   
   } else {                                              
    $interval		= 86400;                               
   }                                                     
   $this->valueOf('filter.RangeStart', $start);            
   $this->valueOf('filter.RangeInterval', $interval);      
  }                                                      
  $start		= $this->valueOf('filter.RangeStart');   
  $interval		= $this->valueOf('filter.RangeInterval');
  if (!$start) {                                       
   $now			= getDate();                         
   $start		= mktime(0,0,0,$now['mon'], 1);      
   $days		= 30;                                
   if (in_array($now['mon'], array(1,3,5,7,8,10,12))) {
    $days		= 31;                                
   }                                                   
   if ($now['mon'] == 2) {                             
    $days		= 28;                                
   }                                                   
   $interval		= $days * 86400;                     
   $this->valueOf('filter.RangeStart', $start);            
   $this->valueOf('filter.RangeInterval', $interval);      
  }
  $this->start		= $start;
  $this->interval	= $interval;
 }
 function getParams($params, $replace=false) {
  foreach ($params as $item) {
   $this->getParam($item, $replace);
  }
 }
 function getParam($name, $replace=false) {
  if (!$replace) {
   $this->$name		= $this->valueOf('filter.'.$name);
  } else {
   $this->$name		= array();
  }
  $items		= & $this->$name;
  if (isset($_GET[$name])) {
   if ($_GET[$name] != '') {
    $prn		= explode(',', $_GET[$name]);
    foreach ($prn as $item) {
     if ($item{0} == '-' && !$replace) {
      $item		= substr($item, 1);
      for ($i = 0; $i < count($items); $i++) {
       if ($items[$i] == $item) {
        array_splice($items, $i, 1);
        break;
       }
      }
     } else {
      $items[]		= $item;
     }
    }
    $items	= array_unique($items);
   } else {
    $items		= array();
   }
   $this->valueOf('filter.'.$name, $items);
  }
 }
}
		
?>