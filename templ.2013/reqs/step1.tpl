<FORM ENCTYPE="multipart/form-data" NAME='reqForm' ACTION="{URL}" method="POST" onSubmit="return check();">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORDER=0>
  <TR CLASS="plain">
   <TD WIDTH=0% NOWRAP>
    ����� ���������
   </TD>
   <TD WIDTH=0% NOWRAP>
    &nbsp;
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    ������������
   </TD>
   <TD>
    {TARGET}
   </TD>
  </TR>
  <TR CLASS="header">
   <TD>
    ����� ��������
   </TD>
   <TD>
    <SELECT CLASS="edit" NAME="CLASS_ID">
     {LIST}
    </SELECT>
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    ��������� ������������
   </TD>
   <TD>
    &nbsp; 
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    ��������� ��������
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
    
   </TD>
  </TR>
  <TR CLASS="plain">
   <TD>
    <BR>
    <INPUT TYPE="button" VALUE="< �����" onClick="document.location='request.php?action=step0';">
    &nbsp;
    <INPUT TYPE="submit" VALUE="������ >">
   </TD>
  </TR>
 </TABLE>
</FORM>
<SCRIPT LANGUAGE="JavaScript">
 function check() {
  if (document.forms[0].CLASS_ID.value == '-') {
   alert('������: �� ��������� ����� ��������.');
   return false;
  } else {
   return true;
  }
 }
 document.forms[0].elements.CLASS_ID.focus();
</SCRIPT>                                