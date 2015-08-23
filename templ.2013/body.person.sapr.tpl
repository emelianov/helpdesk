<A HREF="request.php?action=myreq&user={LOGIN}">User's requests</A><BR>
<B>Host(s) status:<B><BR>
<TABLE>
 {HOSTS}
</TABLE>
<TABLE>
 <TR>
  <TD>
<B>AD Information</B><BR>
<TABLE CLASS="plain">
 <TR><TD>Description</TD><TD>{DESCRIPTION}</TD></TR>
 <TR><TD>SAMAccountName</TD><TD>{LOGIN}</TD></TR>
 <TR><TD>Last logon</TD><TD>{LASTLOGON}</TD></TR>
 <TR><TD>Last logon timestamp</TD><TD>{LASTLOGONTS}</TD></TR>
 <TR><TD>Last logoff</TD><TD>{LASTLOGOFF}</TD></TR> 
 <TR><TD>Bad password time</TD><TD>{BADPASSWORD}</TD></TR>
 <TR><TD>Password last set</TD><TD>{PWDLASTSET}</TD></TR>
 <TR><TD>Logon count</TD><TD>{LOGONCOUNT}</TD></TR>
 <TR><TD>Created</TD><TD>{WHENCREATED}</TD></TR>
 <TR><TD>Changed</TD><TD>{WHENCHANGED}</TD></TR>
 <TR><TD>Member of</TD><TD>{MEMBEROF}</TD></TR>
</TABLE>
  </TD>
  <TD>
   &nbsp;&nbsp;&nbsp;
  </TD>
  <TD VALIGN="top">
<B>Оборудование</B>
<TABLE>
 {HW}
</TABLE>
<BR>
<B>Software</B>
<TABLE>
 {SW}
</TABLE>
  </TD>
 </TR>
</TABLE>