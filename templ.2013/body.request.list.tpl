<SCRIPT LANGEUAGE="JavaScript">
 function qsfilter(obj) {
  if (obj.options[obj.options.selectedIndex].value != '') {
   if (obj.options[obj.options.selectedIndex].value == 'USER') {
    document.forms.mainForm.USER_LIST.disabled = false;
    document.forms.mainForm.SEARCH_TEXT.disabled = true;
    document.forms.mainForm.SEARCH_BUTTON.disabled = true;
   } else {
    if (obj.options[obj.options.selectedIndex].value == 'FULLTEXT') {
     document.forms.mainForm.USER_LIST.disabled = true;
     document.forms.mainForm.SEARCH_TEXT.disabled = false;
     document.forms.mainForm.SEARCH_BUTTON.disabled = false;
     document.forms.mainForm.SEARCH_TEXT.value = '';
     document.forms.mainForm.SEARCH_TEXT.focus();
    } else {
     document.location=obj.options[obj.options.selectedIndex].value;
    }
   }
  } else {
   document.forms.mainForm.USER_LIST.disabled = true;
   document.forms.mainForm.SEARCH_TEXT.disabled = true;
   document.forms.mainForm.SEARCH_BUTTON.disabled = true;
   document.forms.mainForm.SEARCH_TEXT.value = ' - Введите текст - ';
  }
 }
 function suserList(obj) {
  if (obj.options[obj.options.selectedIndex].value != '') {
   document.location="?action=myreq&user="+obj.options[obj.options.selectedIndex].value;   
  }
 }
 function suserText() {
  if (document.forms.mainForm.SEARCH_TEXT.value != '') {
   document.location="?action=fulltext&value="+document.forms.mainForm.SEARCH_TEXT.value;
  }
 }
</SCRIPT>

<FORM CLASS="palin" NAME="mainForm" METHOD="POST" ACTION="">

<TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR CLASS="header">
  <TD WIDTH=50%>
    <B><H4><FONT COLOR=white>{TITLE_REQ}</FONT></H4></B>
  </TD>
  <TD>
   <INPUT TYPE="button" VALUE="Создать заявку" onClick="document.location='?action=new'">
  </TD>
  <TD ALIGN=right>
   <A HREF="?page={DISPLAY_PREV}"><<</A>{DISPLAY_FROM}..{DISPLAY_TO}<A HREF="?page={DISPLAY_NEXT}">>></A>
  </TD>
 </TR>
 <TR>
  <TD VALIGN=center COLSPAN=3>
   &nbsp;Фильтр
   <SELECT CLASS="edit" NAME="qfilter" onChange="qsfilter(this);">
    <OPTION VALUE=""> - Выберите фильтр - </OPTION>
    <OPTION VALUE="?action=myreq">Мои заявки</OPTION>
    <OPTION VALUE="?action=allreq">Все заявки</OPTION>
    <OPTION VALUE="?action=donereq">Без активных операций</OPTION>
    <OPTION VALUE="USER">По пользователю</OPTION>
    <OPTION VALUE="FULLTEXT">По вхождению</OPTION>
   </SELECT>
   <SELECT CLASS="edit" NAME="USER_LIST" onClick="suserList(this);" DISABLED>
    <OPTION VALUE=""> - Выберите пользователя - </OPTION>
    {SELECT_LIST}
   </SELECT>
   <INPUT CLASS="edit" NAME="SEARCH_TEXT" VALUE=" - Введите текст - " DISABLED>
   <INPUT TYPE="button" NAME="SEARCH_BUTTON" VALUE="Найти" onClick="suserText();" DISABLED>
  </TD>
 </TR>
</TABLE>
<TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
 {TABLE_HEADER}
 </TR>
 {CALLS_LIST}
</TABLE>
</FORM>