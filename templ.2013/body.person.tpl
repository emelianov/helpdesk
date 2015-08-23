<SCRIPT LANGUAGE="JavaScript">
var timeoutID;
function goBack() {
 window.history.back();
}
function resetTimeout() {
clearTimeout(timeoutID);
timeoutID = setTimeout('goBack();',5000);
}

window.onmouseover = resetTimeout;
resetTimeout();

</SCRIPT>

<TABLE CLASS="plain" WIDTH=0% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
  <TD VALIGN=top>
  <TABLE CLASS="plain">
   <TR>
    <TD COLSPAN=2>
     <B>{LASTNAME} {FIRSTNAME}</B>
    </TD>
   </TR>
   <TR>
    <TD>
     {PTITLE}
    </TD>   
   </TR>
   <TR>
    <TD>
     Комната: {ROOM}
    </TD>
   </TR>
   <TR>
    <TD>
     &nbsp;
    </TD>
   </TR>
   <TR>
    <TD>
     Телефон[ы]
    </TD>
   </TR>
   <TR>
    <TD>
     {PHONE}
    </TD>
   </TR>
   <TR>
    <TD>
     &nbsp;
    </TD>
   </TR>
  </TABLE>
 </TD>
</TABLE>
{SAPR_DETALES}