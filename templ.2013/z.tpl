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
