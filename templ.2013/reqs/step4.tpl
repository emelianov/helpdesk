<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST" onSubmit="return check();">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORDER=0>
  <TR CLASS="plain">
   <TD WIDTH=0% NOWRAP>
    Общие положения
   </TD>
   <TD WIDTH=0% NOWRAP>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    Пользователь
   </TD>
   <TD>
    {TARGET}
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    Класс проблемы
   </TD>
   <TD>
    {CLASS}
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    Компьютер пользоваетля
   </TD>
   <TD>
    {PC}
   </TD>
  </TR>
  <TR CLASS="header">                                      
   <TD COLSPAN=2>                                                   
    Детальное описание <BR>
    <TEXTAREA CLASS="edit" NAME="TEXT" COLS=80 ROWS=20></TEXTAREA>
   </TD>                                                  
  </TR>                                                   
  <TR CLASS="header">                                      
   <TD COLSPAN=2>                                                   
    Файл (опционально) <BR>
    <INPUT TYPE="file" CLASS="edit" NAME="FILENAME" SIZE=50>
   </TD>                                                  
  </TR>                                                   
  <TR CLASS="header" COLSPAN=2>
   <TD COLSPAN=2>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain" COLSPAN=2>
   <TD COLSPAN=2>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=2>
    <BR>
    <INPUT TYPE="button" VALUE="< Назад" onClick="document.location='{BACK_URL}'">
    &nbsp;
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
 document.reqForm.elements.TEXT.focus();
</SCRIPT>