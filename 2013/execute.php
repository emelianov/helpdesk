<?php
//execute.php v5.0.0

setlocale(LC_ALL, 'ru_RU');
require_once('config.php');               
require_once('lib5.php');
                                          
//$tpl            = &initFastTemplate();    

//$ses            = new Session5();

header('Content-type: application/octet-stream; charset=windows-1251');
header('Content-disposition: inline; filename=radmin.cmd');

$comp		= $_GET['name'];
$path		= "\\\\TONIPI-FS-01V\\DFS\\Install\\Set\\RAdmin\\RClient";
?>

IF "%1" == "/EXEC" GOTO :_EXEC
COPY \\TONIPI-FS-01V\DFS\Install\Set\RAdmin\RClient\set.cmd .
ECHO Введите имя пользователя с указанием домена
ECHO (Для завершения ввода Ctrl-Z, Enter):
COPY con setTMP.cmd /Y
COPY set.cmd+setTMP.cmd run.cmd /Y
CALL run.cmd
COPY \\TONIPI-FS-01V\DFS\Install\Set\RAdmin\RClient\set2.cmd .
CD >> set2.cmd
CALL set2.cmd

:_EXEC

<?php

echo "ECHO CALL $path\\sc \\\\$comp start RAdmin >%TEMP%\\run.cmd\r\n";
switch ($_GET['action']) {
case 'viewonly':
 echo "$path\\RAdmin.exe /connect:$comp:4899 /noinput >>%TEMP%\\run.cmd\r\n";
 break;
case 'telnet':
 echo "ECHO $path\\RAdmin.exe /connect:$comp:4899 /telnet >>%TEMP%\\run.cmd\r\n";
 break;
case 'filetransfer':
 echo "ECHO $path\\RAdmin.exe /connect:$comp:4899 /file >>%TEMP%\\run.cmd\r\n";
 break;
default:
 echo "ECHO $path\\RAdmin.exe /connect:$comp:4899 >>%TEMP%\\run.cmd\r\n";
}
echo "ECHO $path\\sc \\\\$comp stop RAdmin >>%TEMP%\\run.cmd\r\n";

?>
RunAs /User:%CURUSER% %TEMP%\run.cmd
:_QUIT
DEL set.cmd
DEL set2.cmd
DEL setTMP.cmd
DEL run.cmd
DEL %TEMP%\run.cmd