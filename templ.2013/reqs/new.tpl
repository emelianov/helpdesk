<DIV CLASS="header"><H4><B>{TITLE_REQ}</B></H4></DIV>
<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST" onSubmit="return check();">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORDER=0>
  <TR CLASS="plain">
   <TD>             
    Создал
   </TD>            
   <TD>             
    <B>{LOGIN}</B>
   </TD>            
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=3>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD CLASS="red" COLSPAN=2>
    Внимание! Если Вы создаете заявку, связанную с проблемами другого пользователя,
 выберите его имя. Это ускорит выполнение заявки.             
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD CLASS="red">             
    Заявка для пользователя
   </TD>            
   <TD CLASS="red">             
    {USER_LIST}
   </TD>
   <TD>
    Ответственный
   </TD>
   <TD>
    {USER_LIST2}
   </TD>            
  </TR>
  <TR CLASS="plain">
   <TD CLASS="red" COLSPAN=2>
    &nbsp;
   </TD>
   <TD>
    {CLASS}
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=4>                                                   
    Детальное описание <BR>
    <TEXTAREA CLASS="edit" NAME="TEXT" COLS=80 ROWS=20></TEXTAREA>
   </TD>                                                  
  </TR>                                                   
  <TR CLASS="plain">                                      
   <TD COLSPAN=2>                                                   
    Файл (необязательно) <BR>
    <INPUT TYPE="file" NAME="FILENAME" SIZE=50>
   </TD>                                                  
  </TR>                                                   
  <TR CLASS="plain" COLSPAN=2>
   <TD COLSPAN=2>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=2>
    <INPUT TYPE="submit" VALUE="Готово">
   </TD>
  </TR>
 </TABLE>
</FORM>
<SCRIPT LANGUAGE="JavaScript">
 function check() {                             
  if (document.reqForm.TEXT.value.length == 0) {
   alert('Ошибка: Необходимо описать проблему');         
   return false;                                
  } else {                                      
   return true;                                 
  }                                             
 }                                              
 function setOption(obj, str) {
  for (var i = 0;i < obj.length && obj.options[i].value != str; i++) {
  }
  if (i < obj.length) {
   obj.selectedIndex = i;
  }
 }
 setOption(document.reqForm.TARGET, '{LOGIN}');
 setOption(document.reqForm.OBJ, '{USERPC}');
 document.reqForm.elements.TEXT.focus();
</SCRIPT>