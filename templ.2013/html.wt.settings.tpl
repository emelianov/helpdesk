<div id="settings" style="left: 0px; position: fixed; _position: absolute; bottom: -10px; background-color: #336">
<form name="settingsForm" method="post" action="?{URLSUFFIX}&action=behalf">
 <input id="io" name="io" type="hidden" value="{TABIO}" />
 <table width="100%">
  <tr class="header"><td id="settingsHeader" colspan=3>Настройки</td></tr>
  <tr>
   <td>
    Заместитель:
    <br>
    <select id="tabIO" class="edit" onChange="document.getElementById('io').value = document.getElementById('tabIO').options[document.getElementById('tabIO').selectedIndex].value">
     <OPTION VALUE="0">Нет</OPTION>
     {IOLIST}
    </select>
    <br>
    <br>
    Предоставлены полномочия замешения:
    {ACTIVEIO}
   </td>
   <td>
    <input type="submit" value="Сохранить" /><br>
    <input type="button" value="Отмена" onclick="hideSettings();" />
   </td>
  </tr>
 </tr></table>
</form>
</div>

<script language="javascript">
 urlsuffix = '{URLSUFFIX}';
 function showSettings(){
  document.getElementById('settings').style.visibility='visible';
 }
 function hideSettings(){
  document.getElementById('settings').style.visibility='hidden';
 }
 function behalf(tab,tabIO) {
  location.href = '?action=behalf&btab='.concat(tab).concat('&btabio=').concat(tabIO).concat('&').concat(urlsuffix);
 }
 hideSettings();
 for (var i = 0;i < document.getElementById('tabIO').length && document.getElementById('tabIO').options[i].value != document.getElementById('io').value; i++) {
 }
 if (i < document.getElementById('tabIO').length) {
  document.getElementById('tabIO').selectedIndex = i;
 } else {
  document.getElementById('tabIO').selectedIndex = 0;
 }
// document.getElementById('tabIO').focus();

</script>

