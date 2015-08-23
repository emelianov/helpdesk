<SCRIPT LANGEUAGE="JavaScript">
 function qfilter(obj) {
  if (obj.options[obj.options.selectedIndex].value != '') {
   document.location=obj.options[obj.options.selectedIndex].value;
  }
 }
</SCRIPT>
<TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
  <TD>
   <INPUT TYPE="button" VALUE="Создать заявку" onClick="document.location='?action=new'">
  </TD>
  <TD ALIGN=right>
   <A HREF="?page={DISPLAY_PREV}"><<</A><A HREF="?page={DISPLAY_NEXT}">>></A>
  </TD>
 </TR>
</TABLE>
<TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
 {TABLE_HEADER}
 </TR>
 {CALLS_LIST}
</TABLE>
