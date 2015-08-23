<div id="edit" style="left: 0px; position: fixed; _position: absolute; bottom: -10px;">
<form name="editForm" method="post" action="?{URLSUFFIX}&action=save" onSubmit="return true;">
 <input id="editID" name="editID" type="hidden" />
 <table width="100%" class="header" border=0 cellspacing=1 cellpadding=1>
 <tr><td>
 <table width="100%" border=0 cellspacing=0 cellpadding=0>
  <tr class="header"><td id="editDate" colspan=3> </td></tr>
  <tr class="plain">
   <td>
       Причина отсутствия в период<br>
       С <div id="editFrom"> </div><br>
       До <div id="editTo"> </div>
   </td>
   <td>
    <textarea name="editText" cols="80" rows="5" maxlength="60"></textarea>
   </td>
   <td>
    <input type="submit" value="Сохранить" /><br>
    <input type="button" value="Отмена" onclick="hideEdit();" />
   </td>
  </tr>
 </table>
 </td></tr>
 </table>
</form>
</div>

<script language="javascript">
 urlsuffix = '{URLSUFFIX}';
 function showEdit(){
  document.getElementById('edit').style.visibility='visible';
 }
 function hideEdit(){
  document.getElementById('edit').style.visibility='hidden';
 }
 function fillEdit(id, date, timeFrom, timeTo, reason){
  document.getElementById('editID').value = id;
  document.getElementById('editDate').innerHTML = date;
  document.getElementById('editFrom').innerHTML = timeFrom;
  document.getElementById('editTo').innerHTML = timeTo;
  document.getElementById('editText').value = reason;
 }
 function approve(id,viza) {
  location.href = '?action=approve&approve='.concat(viza).concat('&id=').concat(id).concat('&').concat(urlsuffix);
 }
 hideEdit();
</script>
