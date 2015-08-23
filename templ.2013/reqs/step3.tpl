<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST">
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
    Класс проблемы
   </TD>
   <TD>
    {CLASS}
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    Объект
   </TD>
   <TD>
    {OBJ}
   </TD>
  </TR>
  <TR CLASS="header">
   <TD>
    ПК
   </TD>
   <TD>
    <SELECT CLASS="edit" NAME="PC">
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
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=2>
    <BR>
    <INPUT TYPE="button" VALUE="< Назад" onClick="document.location='request.php?action=step2';">
    &nbsp;
    <INPUT TYPE="submit" VALUE="Дальше >">
   </TD>
  </TR>
 </TABLE>
</FORM>
<SCRIPT LANGUAGE="JavaScript">           
 document.forms[0].elements.OBJ.focus();
</SCRIPT>                                