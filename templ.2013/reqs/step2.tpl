<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST" onSubmit="return check();">
 <TABLE CLASS="plain" WIDTH=100% CELLPADDING=0 CELLSPACING=0 BOERDER=0>
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
  <TR CLASS="header">
   <TD>
    Компьтер пользователя
   </TD>
   <TD>
    <SELECT CLASS="edit" NAME="OBJ">
     {LIST}
    </SELECT>
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    Детальное описание
   </TD>
   <TD>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="header">
   <TD COLSPAN=2>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=2>
    <BR>
    <INPUT TYPE="button" VALUE="< Назад" onClick="document.location='request.php?action=step1';">
    &nbsp;
    <INPUT TYPE="submit" VALUE="Дальше >">
   </TD>
  </TR>
 </TABLE>
</FORM>
<SCRIPT LANGUAGE="JavaScript">           
 function check() {                             
  if (document.forms[0].OBJ.value.length == 0) {
   alert('Ощибка: не выбран объект');         
   return false;                                
  } else {                                        
   return true;                                 
  }                                             
 }                                              
 document.forms[0].elements.OBJ.focus();
</SCRIPT>                                