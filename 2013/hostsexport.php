<?php
//hostsexport.php v5.0.0

setlocale(LC_ALL, 'ru_RU');

header('Content-type: text/plain; charset=windows-1251');

require_once('config.php');
require_once(OLIB_PATH.'/class.ad.php');        
require_once(OLIB_PATH.'/class.session.php');     

$tpl		= &initFastTemplate();
$tpl->define(Array(     'host'		=> '../templ.export/host.tpl'
	    ));

$ses		= new Session(TRUE);
$tpl->assign('MESSAGE', $ses->msg());
$objs		= new Computer('TONIPI-*');
$objs->fieldUpper('cn');
$objs->sortBy('cn');
for ($i = 0; $i < $objs->count; $i++) {
 if (isset($objs->location[$i]) && strlen($objs->location[$i]) > 0) {
  $tpl->assign(Array(	'HOST_IP'	=> $objs->location[$i],
			'HOST_NAME'	=> $objs->cn[$i],
			'HOST_FULLNAME'	=> $objs->cn[$i].'.oao.sng',
			'HOST_USERNAME'	=> $objs->description[$i]
		));
  $tpl->parse(BODY, '.host');
 }
}
//$tpl->parse('BODY', 'empty');
$tpl->FastPrint();
?>