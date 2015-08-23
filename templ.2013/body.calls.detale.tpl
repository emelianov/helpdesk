<TABLE  CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
 <TR>
  <TD WIDTH=100% VALIGN=top>
   <B>{TIME}</B>
   {USER_LIST}
   <TABLE CLASS="plain" WIDTH=100% CELLSPACING=0 CELLPADDING=0 BORED=0>
    <TR>
     <TD NOWRAP><B>Телефон</B></TD>
     <TD NOWRAP><B><A HREF="calls.php?sort=time" TITLE="Отсортировать по времени звонка">Время</B></A></TD>
     <TD NOWRAP><B><A HREF="calls.php?sort=external_id" TITLE="Отсортировать по номеру">Телефон</A></B></TD>
     <TD NOWRAP ALIGN=right><B><A HREF="calls.php?sort=duration" TITLE="Отсортировать по продолжительности звонков">Продолжительность</A></B></TD>   
     <TD NOWRAP ALIGN=right><B><A HREF="calls.php?sort=money" TITLE="Отсортировать по сумме">Сумма</A></B></TD>
    </TR>
    {CALLS_LIST}
    <TR>
     <TD NOWRAP><B>Городские звонки</B></TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD ALIGN=right><B>{LOCAL_MIN}</B></TD>   
     <TD>&nbsp</TD>           
    </TR>
    <TR>
     <TD NOWRAP><B>Междугородние звонки ко каналу</B></TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD ALIGN=right><B>{CHANN_MIN}</B></TD>   
     <TD>&nbsp</TD>           
    </TR>
    <TR>
     <TD NOWRAP><B>Междугородние звонки</B></TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD NOWRAP>&nbsp;</TD>
     <TD ALIGN=right><B>{SHORT_MIN}</B></TD>   
     <TD ALIGN=right><B>{SHORT_SUM}</B></TD>           
    </TR>
   </TABLE>
  </TD>
  <TD WIDTH=0% ALIGN=center VALIGN=top>
   <SCRIPT LANGUAGE="JavaScript">
    year = 2004;
    show_cal("April",30,4);
   </SCRIPT>
   <BR>
   <A HREF="calls.php?phone="><B>Все телефоны</B></A>
  </TD>
 </TR>
</TABLE>