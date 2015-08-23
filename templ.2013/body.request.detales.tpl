<SCRIPT LANGUAGE="JavaScript">
 function sub(act) { 
  document.forms.bodyForm.ACTION.value = act;
  if (act == 'process' || act == 'curator' || act == 'end' || act == 'delay' || act == 'overtake') {
   if (act == 'process') {
    if (document.forms.bodyForm.USER_LIST.value == '') {
     alert('Необходимо выбрать исполнителя');
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
    alert("Необходимо выбрать операцию");
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
     <TD ROWSPAN=10>
      <TABLE CLASS="button" WIDTH=250 CELLSPACING=0 CELLPADDING=0 BORDER=2>
       <TR><TD><A CLASS="button" HREF="javascript:sub('{TAKE_ACTION}')">{TAKE_TEXT}</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('delay')">Отложить заявку</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('end')">Завершить заявку</A></TD></TR>
       <TR><TD><A CLASS="button" HREF="javascript:sub('{TAKE_ACTION}')">{TAKE_TEXT}</A></TD></TR>
      </TABLE>
     </TD>
     </TR>
     </TD>
    </TR>
    <TR>
     <TD>
      Создан
     </TD>
     <TD>
      {TIME} ({CREATOR})
     </TD>
     <TD>
      Создал
     </TD>
     <TD>
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
      <A HREF="/devel/req.php?action=edit&id={RID}">[Edit]</A>
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
   <DIV ALIGN=right> Операции по заявке</DIV>

 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
  {TABLE_HEADER}
  </TR>
  {CALLS_LIST}
 </TABLE>
  <DIV CLASS="plain">
 <INPUT TYPE="button" VALUE="Комментарий" onClick="sub('comment')">
 <INPUT TYPE="button" VALUE="Принять" onclick="sub('take')">
 <INPUT TYPE="button" VALUE="Готово" onClick="sub('done')">
 <INPUT TYPE="button" VALUE="Отклонить" onClick="sub('timeout')">
 <INPUT TYPE="button" VALUE="Удалить" onClick="sub('delete')">
 </DIV>
 <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
  <TR>
   <TD WIDTH=0%>
    Комментарий
   </TD>
   <TD WIDTH=100%>
    <TEXTAREA CLASS="edit" NAME="TEXT" COLS=80 ROWS=8></TEXTAREA>
   </TD>
  </TR>
  <TR>
   <TD WIDTH=0%>
    <INPUT TYPE="button" VALUE="Создать операцию" onClick="sub('process')">
   </TD>
   <TD>
    Исполнитель
    <SELECT NAME="USER_LIST">
     <OPTION VALUE="">Только для "Создать операцию"</OPTION>
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


   <DIV ALIGN=right> Активные операции по заявкам</DIV>
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
