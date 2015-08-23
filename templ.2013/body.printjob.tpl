<SCRIPT LANGUAGE="JavaScript">
 function str2time(s) {
  d = new Date(s.substring(6), s.substring(3, 5)-1, s.substring(0,2));
  return (d.getTime()/1000);
 }
 function setLocation() {
  if ((document.mainForm.startDate.value == '') || (document.mainForm.endDate.value == '')) {
   alert('Date missing');
  } else {
   strt = str2time(document.mainForm.startDate.value);
   endd = str2time(document.mainForm.endDate.value);
   if (strt > endd) {
    tmp = strt;
    strt = endd;
    endd = tmp;
   }
   endd += 86400;
   newLoc = '';
   f ='';
   if (document.mainForm.filter_values != undefined) {
    for (i=0; i<document.mainForm.filter_values.length; i++) {
     if (document.mainForm.filter_values[i].checked) {
      p = document.mainForm.filter_values[i].value.indexOf('.');
      newLoc = newLoc + ((newLoc.length > 0)?',':'') + document.mainForm.filter_values[i].value.substr(p + 1);
      f = document.mainForm.filter_values[i].value.substr(0, p);
     }
    }
   }
   c = 'firstcol=' + document.mainForm.first_column.value;
   d = 'det=' + (document.mainForm.detales.checked?'On':'Off');
   newLoc = "?start=" + strt + "&interval=" + (endd - strt) + '&' + f + '=' + newLoc + '&' + c + '&' + d;
   document.location = document.location.hash + newLoc;
  }
 }
 function chooseUser(users) {
  for (j = 0; j < document.mainForm.filter_values.length; j++) {
   for (i = 0; i < users.length; i++) {
    if (document.mainForm.filter_values[j].value == users[i]) {
     document.mainForm.filter_values[j].checked = !document.mainForm.filter_values[j].checked;
    }
   }
  }
 }
</SCRIPT>
<A HREF="?action=export" TITLE="Нажмите на правую клявишу мыши и выберите 'Сохранить объект как...'">Экспорт в .csv</A>
<FORM name="mainForm" id="mainForm" method="POST" action="...">
<TABLE  CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
  <TD WIDTH=100% VALIGN=top>
   <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     {TABLE_HEADER}
    </TR>
    {CALLS_LIST}
   </TABLE>
   <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     <TD>
      Всего A4
     </TD>
     <TD>
      {A4}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего A3
     </TD>
     <TD>
      {A3}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего A2
     </TD>
     <TD>
      {A2}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего A1
     </TD>
     <TD>
      {A1}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего A0
     </TD>
     <TD>
      {A0}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего Default
     </TD>
     <TD>
      {DEFAULT}
     </TD>
    </TR>
    <TR>
     <TD>
      Всего прочих
     </TD>
     <TD>
      {OTHER}
     </TD>
    </TR>
   </TABLE>
  </TD>
  <TD WIDTH=0% ALIGN=center VALIGN=top>
   <TABLE CLASS="header" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     <TD COLSPAN=2>Дата</TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      С
     </TD>
     <TD ALIGN=right>
      <input CLASS="edit" type="text" name="startDate" id="startDate" READONLY size=10 value="{START_DATE}" onfocus="showCalendar(event)">
     </TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      По
     </TD>
     <TD ALIGN=right>
      <input CLASS="edit" type="text" name="endDate" id="endDate" READONLY size="10" value="{END_DATE}" onfocus="showCalendar(event)">
     </TD>
    </TR>
   </TABLE>
   <BR>
   <BR>
   <BR>
   <BR>
   <TABLE CLASS="header" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     <TD COLSPAN=2>Фильтр</TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      <A HREF="{URL_CLEAR_PRN}" TITLE="Удалить все">Принтер</A>
     </TD>
     <TD ALIGN=right>
      {PRN_NAMES}
     </TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      <A HREF="{URL_CLEAR_USER}" TITLE="Удалить все">Пользователь</A>
     </TD>
     <TD ALIGN=right>
      {USER_NAMES}
     </TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      <A HREF="{URL_CLEAR_PAPER}" TITLE="Удалить все">Бумага</A>
     </TD>
     <TD ALIGN=right>
      {PAPER_NAMES}
     </TD>
    </TR>
   </TABLE>
   <BR>
   <TABLE CLASS="header" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     <TD COLSPAN=2>Вид</TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      Первый столбец
     </TD>
     <TD ALIGN=right>
     <SELECT CLASS="edit" NAME="first_column">
     <OPTION {PRN_SELECTED} VALUE="printer">Принтер</OPTION>
     <OPTION {USER_SELECTED} VALUE="user">Пользователь</OPTION>
     </SELECT>
     </TD>
    </TR>
    <TR CLASS="plain">
     <TD>
      Отображать детали
     </TD>
     <TD ALIGN=right>
      <INPUT TYPE="checkbox" CLASS="plain" NAME="detales" {DETALES_CHECKED}>
     </TD>
    </TR>
   </TABLE>
   <BR>
   <INPUT TYPE="button" VALUE="Применить фильтр" onclick="setLocation(); return false;">
  </FORM>
   <BR>
   <A HREF="{URL_USERCHOOSE}"  TITLE="Выбор из списка всех пользователей"><B>Выбор пользователя</B></A>
   <BR>
   <A HREF="{URL_CLEAR_ALL}"  TITLE="Сброс всех параметров фильтра"><B>Очистить фильтр</B></A>
  </TD>
 </TR>
</TABLE>