<SCRIPT LANGUAGE="JavaScript">
 function sub(act) { 
  document.forms.bodyForm.ACTION.value = act;
  document.forms.bodyForm.CID.value = 0;
  for (i=0; i<document.forms.bodyForm.filter_values.length; i++) {
   if (document.forms.bodyForm.filter_values[i].checked) {
    document.forms.bodyForm.CID.value = parseInt(document.forms.bodyForm.CID.value, 10) + parseInt(document.forms.bodyForm.filter_values[i].value, 0);
   }
  }
     return document.forms.bodyForm.submit();
 }
</SCRIPT>
<FORM ENCTYPE="multipart/form-data" ACTION="" method="POST" NAME="bodyForm">
 {FIELDS_DATA}
 <INPUT TYPE="button" VALUE="Save" onClick="sub('{FIELDS_ACTION}')">
 <INPUT TYPE="button" VALUE="Cancel" onClick="window.close()">
 <INPUT TYPE="hidden" NAME="ACTION" VALUE="">
 <INPUT TYPE="hidden" NAME="RID" VALUE="{RID}">
 <INPUT TYPE="hidden" NAME="CID" VALUE="{CID}">
</FORM>