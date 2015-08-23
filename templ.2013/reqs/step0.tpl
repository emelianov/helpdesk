<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST">
 <INPUT TYPE="hidden" NAME="ID" VALUE="{ID}">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORDER=0>
  <TR CLASS="header">
   <TD WIDTH=0% NOWRAP>
    Общие положения
   </TD>
   <TD WIDTH=0% NOWRAP>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="header">
   <TD>             
    Заказчик
   </TD>            
   <TD>             
    {USER_LIST}
    Ответственный {USER_LIST2}
   </TD>            
  </TR>             
  <TR CLASS="plain">
   <TD>             
    Класс проблемы
   </TD>            
   <TD>             
    &nbsp;          
   </TD>            
  </TR>             
  <TR CLASS="plain">
   <TD>             
    Компьютер пользователя
   </TD>            
   <TD>             
    &nbsp;          
   </TD>            
  </TR>             
  <TR CLASS="plain">
   <TD>             
    Описание проблемы
   </TD>            
   <TD>             
    &nbsp;          
   </TD>            
  </TR>             
  <TR CLASS="header">
   <TD COLSPAN=2>
    <IMG SRC="/img/whitepel.gif" WIDTH=1 HEIGHT=1 BORDER=0>
   </TD>
  </TR>
  <TR>
   <TD>
    
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD COLSPAN=2>
    <BR>
    <BR>
    <INPUT TYPE="button" VALUE="< Назад" DISABLED>
    &nbsp;
    <INPUT TYPE="submit" VALUE="Дальше >">
    <BR>
<BR>
<B>Термины</B>
<BR>
Заказчик - Пользователь, для которого создана заявка.
<BR>
Исполнитель - Сотрудник отдела СПО выполняющий заявку или её часть.
<BR>
Ответственный - Сотрудник отдела СПО осуществляющий контроль за выполнением заявки. Рекомендуется оставлять в _Auto за исключением тех случаев, когда Исполнитель создающий заявку будет непосредственно заниматься её выполнением.
   </TD>
  </TR>
 </TABLE>
</FORM>
