<SCRIPT LANGUAGE="JavaScript">
 function sub(act) { 
  document.forms.bodyForm.ACTION.value = act;
  if (act == 'process' || act == 'curator' || act == 'end' || act == 'unend' || act == 'usercomment') {
   if (act == 'usercomment') {
    document.forms.bodyForm.RID.value = {RID};
   }
   return document.forms.bodyForm.submit();
  } else {
   if (document.forms.bodyForm.filter_values.length == undefined) {
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
    alert("Check action first");
   }
  }
 }
</SCRIPT>
<FORM ENCTYPE="multipart/form-data" ACTION="" method="POST" NAME="bodyForm">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
   <TD>
    Статус
   </TD>
   <TD>
    {RESULT}
   </TD>
   <TD>
    Ответственный
   </TD>
   <TD>
    {CURATOR}
   </TD>
   <TD>
   </TD>
  </TR>
  <TR>
   <TD>
    Создан
   </TD>
   <TD>
    {TIME}
   </TD>
   <TD>
    Создал
   </TD>
   <TD>
    {CREATOR}
   </TD>
   <TD>
   </TD>
  </TR>
  <TR>
   <TD>
    Завершен
   </TD>
   <TD>
    {DONE}
   </TD>
   <TD>
    Завершил
   </TD>
   <TD>
    {USERNAME2}
   </TD>
   <TD>
   </TD>
  </TR>
  <TR>
   <TD>
    Заявка для пользователя
   </TD>
   <TD>
    {TARGET}
   </TD>
   <TD COLSPAN=2>
    <A HREF="?action=myreq&user={TARGETNAME}">Другие заявки этого пользователя</A>
   </TD>
  </TR>
  <TR>
   <TD>
    Дополнительные данные
   </TD>
   <TD>
    {FILE}
   </TD>
  </TR>
 </TABLE>
 <DIV CLASS="plain">

 <FONT COLOR=999999>
&nbsp;&nbsp;&nbsp;{TEXT}
 </FONT>
 <BR>
&nbsp;&nbsp;&nbsp;{COMMENT}
 <BR>
 {REQ_BUTTONS}
 </DIV>
 <HR>
 <INPUT TYPE="hidden" NAME="ACTION" VALUE="">
 <INPUT TYPE="hidden" NAME="RID" VALUE="{RID}">
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
  {TABLE_HEADER}
  </TR>
  {CALLS_LIST}
 </TABLE>
 <HR>                                                                
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>                                                               
   {TABLE_HEADER}                                                     
  </TR>                                                              
  {TASKS_LIST}                                                       
  </TABLE>                                                            
</FORM>