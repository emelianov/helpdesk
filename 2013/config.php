<?php
//config.php	v2013
error_reporting(E_ALL);

//Global settings
define('OTPL_PATH',     	'../templ.2013');
define('OLIB_PATH',		'../lib.5.3.0');
define('SERV_PATH',		'http://10.124.13.24/2013');
define('REL_PATH',		'/2013');
define('USERLIST_TTL',		7200);
define('PERSONS_TTL',		86400);
define('ROWS_PER_PAGE',		150);

define('PHOTOPATH',		'../van/photo');
define('PHOTOABSENT',		'99999999');
define('PHOTOABSENTALT',	'88888888');
//Requests settings
define('OREQ_ALL_TABLE',    	'requests');               
define('OREQ_USERLIST', 	'Group-TONIPI-Web SAPR');       
define('OREQ_ADMIN',    	'Group-TONIPI-Web Admin'); 
define('OREQ_INFORM',   	'Group-TONIPI-Web Inform');
define('OREQ_FTS_TBL',   	'search_requests');
define('OREQ_TITLE',		'������ � ����');
define('OREQ_CSS',		'v2.css');

define('OREQ_PDM_TABLE',	'pdm');               
define('OREQ_PDM_USERLIST', 	'Group-TONIPI-Web PDM');       
define('OREQ_PDM_ADMIN',    	'Group-TONIPI-Web PDM Admin'); 
define('OREQ_PDM_INFORM',   	'Group-TONIPI-Web PDM Inform');
define('OREQ_PDM_FTS_TBL',   	'search_pdm');
define('OREQ_PDM_TITLE',	'��� "�����"');
define('OREQ_PDM_CSS',		'v2.css');

define('OREQ_OMTS_TABLE',	'omts');               
define('OREQ_OMTS_USERLIST', 	'Group-TONIPI-Web OMTS');       
define('OREQ_OMTS_ADMIN',    	'Group-TONIPI-Web OMTS Admin'); 
define('OREQ_OMTS_INFORM',   	'Group-TONIPI-Web OMTS Inform');
define('OREQ_OMTS_FTS_TBL',   	'search_omts');
define('OREQ_OMTS_TITLE',	'������ � ���������������-����������� �����');
define('OREQ_OMTS_CSS',		'v2_omts.css');

//Login settings
define('LOGIN_URL',		'/tmn/login.php');


//NLS
define('T_HELP',		'������');
define('T_SETTINGS',		'���������');
define('T_BACK',		'�����');
define('T_HOME',		'��������� ��������');
define('T_YES',			'��');
define('T_NO',			'���');
define('T_REPLACER',		'�����������');
define('T_REPLACING',		'��������');
define('T_SAVE',		'���������');
define('T_CANCEL',		'������');





?>