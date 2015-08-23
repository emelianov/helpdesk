<SCRIPT LANGUAGE="JavaScript">
 function putUserName(obj) {
  if (document.forms.bodyForm.elements.LOGIN.value == '-') {
   document.forms.bodyForm.USERNAME.value = '';
   document.forms.bodyForm.USERNAME.focus();
  } else {
   document.forms.bodyForm.USERNAME.value = document.forms.bodyForm.elements.LOGIN.value;
   document.forms.bodyForm.PASS.focus();
  }
 }
 function saveUN() {
  var expire = new Date();                                                  
  expire.setTime(expire.getTime() + 365*24*360000);
  document.cookie = 'TMN_USERNAME=' + document.forms.bodyForm.elements.USERNAME.value + ';expires=' + expire.toGMTString() + '; path=/;';
  return true;
 }
</SCRIPT>
<FORM NAME="bodyForm" ENCTYPE="multipart/form-data" ACTION="{URL}" method="POST" onSubmit="saveUN();">
 <TABLE CLASS="plain">
  <TR>
   <TD>
   </TD>
   <TD>
    <SELECT CLASS="edit" NAME="LOGIN" onChange="putUserName();">
     {USER_LIST}
    </SELECT>
   </TD>
  </TR>
  <TR>
   <TD>
    Логин:
   </TD>
   <TD>
    <INPUT CLASS="edit" NAME="USERNAME" VALUE="">
   </TD>
  </TR>
  <TR>
   <TD>
    Пароль:
   </TD>
   <TD>
    <INPUT CLASS="edit" TYPE="password" NAME="PASS" VALUE="">
   </TD>
  </TR>
 </TABLE>
 <INPUT TYPE="submit" VALUE="Войти">
</FORM>
<SCRIPT LANGUAGE="JavaScript">
 username = getCookie('TMN_USERNAME');
 for (var i = 0;i < document.forms.bodyForm.LOGIN.length && document.forms.bodyForm.LOGIN.options[i].value != username; i++) {
 }
 if (i < document.forms.bodyForm.LOGIN.length) {
  document.forms.bodyForm.LOGIN.selectedIndex = i;
 }
 if (document.forms.bodyForm.LOGIN.value != '-') {
  document.forms.bodyForm.USERNAME.value = document.forms.bodyForm.LOGIN.value;
  document.forms.bodyForm.PASS.focus();
 } else {
  document.forms.bodyForm.USERNAME.focus();
 }
</SCRIPT>