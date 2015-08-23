<!DOCTYPE html>
<HTML>
  <!-- {DEBUG} --/>
 <HEAD>
  <META http-equiv="Content-type" content="text/html; charset=windows-1251">
  <META charset=windows-1251">
  <SCRIPT LANGUAGE="JavaScript">
   var infoDate={INFODATE};
  </SCRIPT>
  <SCRIPT SRC="/tmn/base.js" TYPE="text/javascript"></SCRIPT>
  <SCRIPT LANGUAGE="JavaScript">
   var css = '{CSS}';
   if (css == '') {
    css = 'v2.css';
   }
   document.write('<LINK REL="stylesheet" HREF="/2013/' + css + '" TYPE="text/css">')
  </SCRIPT>
  <TITLE>{TITLE}</TITLE>
 </HEAD>
 <BODY>
  {BODYSTART}
  <TABLE CLASS="menu" WIDTH="100%">
   <TR>
    <TD height=17px ALIGN="left">{NAVIGATE}</TD>
    <TD HEIGHT=17px ALIGN="right"><B>ТО СургутНИПИнефть <FONT COLOR=red>2013</FONT></B></TD>
   </TR>
  </TABLE>
  <TABLE WIDTH=100% BORDER=0 CELLSACING=1 CELLPADDING=2>
   <TR><TD>{BODY}</TD></TR>
  </TABLE>
  <SCRIPT LANGUAGE="JavaScript">
   var message = '{MESSAGE}';
   if (message.length > 0) {
    alert(message);
   }
  </SCRIPT>
 </BODY>
</HTML>
