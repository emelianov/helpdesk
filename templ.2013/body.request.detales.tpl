<SCRIPT LANGUAGE="JavaScript">
 function sub(act) { 
  document.forms.bodyForm.ACTION.value = act;
  if (act == 'process' || act == 'curator' || act == 'end' || act == 'delay' || act == 'overtake') {
   if (act == 'process') {
    if (document.forms.bodyForm.USER_LIST.value == '') {
     alert('���������� ������� �����������');
     return false;
    }
   }
   return document.forms.bodyForm.submit();
  } else {
   if (document.forms.bodyForm.filter_values.length == "undefined") {
    if (document.forms.bodyForm.filter_values.checked) {
     document.forms.bodyForm.RID.value = document.forms.bodyForm.filter_values.value;
     return document.forms.bodyForm.submit();
    } else {
     alert("Check action first");
    }
   } else {
    for (i=0; i<document.forms.bodyForm.filter_values.length; i++) {
     if (document.forms.bodyForm.filter_values[i].checked) {
      document.forms.bodyForm.RID.value = document.forms.bodyForm.filter_values[i].value;     
      return document.forms.bodyForm.submit();
     }
    }
   }
   if (i>=document.forms.bodyForm.filter_values.length) {
    alert("���������� ������� ��������");
   }
  }
 }
</SCRIPT>
<FORM ENCTYPE="multipart/form-data" ACTION="" method="POST" NAME="bodyForm">
 <INPUT TYPE="hidden" NAME="ACTION" VALUE="">
 <INPUT TYPE="hidden" NAME="RID" VALUE="{RID}">
 
<TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
 <TABLE CLASS="border" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
  <TR>
   <TD WIDTH=5px>&nbsp;</TD>
   <TD WIDTH=100%>
   <DIV ALIGN=right>{RID}</DIV>
    <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
     <TR>
      <TD>
       ������
      </TD>
     <TD>
      {RESULT}
     </TD>
     <TD>
      �������������
     </TD>
     <TD>
      {CURATOR}
     </TD>
     <TD>
     </TD>
     <TD ROWSPAN=10>
      <TABLE CLASS="button" WIDTH=250 CELLSPACING=0 CELLPADDING=0 BORDER=2>
       <TR><TD><A CLASS="button" HREF="javascript:sub('{TAKE_ACTION}')">{TAKE_TEXT}</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('delay')">�������� ������</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('end')">��������� ������</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('{TAKE_ACTION}')">{TAKE_TEXT}</A></TD></TR>
      </TABLE>
     </TD>
     </TR>
     </TD>
    </TR>
    <TR>
     <TD>
      ������
     </TD>
     <TD>
      {TIME} ({CREATOR})
     </TD>
     <TD>
      ������
     </TD>
     <TD>
     </TD>
     <TD>
     </TD>
    </TR>
    <TR>
     <TD>
      ��������
     </TD>
     <TD>
      {DONE}
     </TD>
     <TD>
      ��������
     </TD>
     <TD>
      {USERNAME2}
     </TD>
     <TD>
     </TD>
    </TR>
    <TR>
     <TD>
      ������ ��� ������������
     </TD>
     <TD>
      {TARGET}
     </TD>
     <TD COLSPAN=2>
      <A HREF="?action=myreq&user={TARGETNAME}">������ ������ ����� ������������</A>
      <A HREF="/devel/req.php?action=edit&id={RID}">[Edit]</A>
     </TD>
    </TR>
    <TR>
     <TD>
      �������������� ������
     </TD>
     <TD>
      {FILE}
     </TD>
    </TR>
    <TR>
     <TD COLSPAN=10>
      <FONT COLOR=999999>
       <INPUT TYPE="radio" NAME="filter_values" VALUE="{RID}">&nbsp;&nbsp;{TEXT}
      </FONT>
      <BR>
      {COMMENT}
      <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
       {COMMENT2}
      </TABLE>
     </TD>
    </TR>
   </TABLE>
  </TD>
  <TD WIDTH=5px>&nbsp;</TD>
 </TR>
 <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
</TABLE>

<BR>
 <TABLE CLASS="border" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
  <TR>
   <TD WIDTH=5px>&nbsp;</TD>
   <TD WIDTH=100%>
   <DIV ALIGN=right> �������� �� ������</DIV>

 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
  {TABLE_HEADER}
  </TR>
  {CALLS_LIST}
 </TABLE>
  <DIV CLASS="plain">
 <INPUT TYPE="button" VALUE="�����������" onClick="sub('comment')">
 <INPUT TYPE="button" VALUE="�������" onclick="sub('take')">
 <INPUT TYPE="button" VALUE="������" onClick="sub('done')">
 <INPUT TYPE="button" VALUE="���������" onClick="sub('timeout')">
 <INPUT TYPE="button" VALUE="�������" onClick="sub('delete')">
 </DIV>
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
   <TD WIDTH=0%>
    �����������
   </TD>
   <TD WIDTH=100%>
    <TEXTAREA CLASS="edit" NAME="TEXT" COLS=80 ROWS=8></TEXTAREA>
   </TD>
  </TR>
  <TR>
   <TD WIDTH=0%>
    <INPUT TYPE="button" VALUE="������� ��������" onClick="sub('process')">
   </TD>
   <TD>
    �����������
    <SELECT NAME="USER_LIST">
     <OPTION VALUE="">������ ��� "������� ��������"</OPTION>
     {USER_LIST}
    </SELECT>
   </TD>
  </TR>
 </TABLE>
  </TD>
  <TD WIDTH=5px>&nbsp;</TD>
 </TR>
 <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
</TABLE>

<BR>

 <TABLE CLASS="border" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
  <TR>
   <TD WIDTH=5px>&nbsp;</TD>
   <TD WIDTH=100%>


   <DIV ALIGN=right> �������� �������� �� �������</DIV>
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
  {TABLE_HEADER}
  </TR>
  {TASKS_LIST}
 </TABLE>

  </TD>
  <TD WIDTH=5px>&nbsp;</TD>
 </TR>
 <TR HEIGHT=5px><TD WIDTH=5px></TD><TD WIDTH=100%><TD WIDTH=5px></TR>
</TABLE>
