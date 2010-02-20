<script language="JavaScript">
var xsize 	= screen.width;
var ysize 	= screen.height;
var breite	= 720;
var hoehe	= 300;
var xpos	= (xsize-breite) / 2;
var ypos	= (ysize-hoehe) / 2;

function f(target_url, win_name) {
var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
new_win.focus();
}

function kb(rid) {
	var kb = window.open("CombatReport.php?raport=" + rid, "kb", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+(xsize-100)+",height="+(ysize-100)+",screenX="+((xsize-(xsize-100))/2)+",screenY="+((ysize-(ysize-100))/2)+",top="+((ysize-(ysize-100))/2)+",left="+((xsize-(xsize-100))/2));
	kb.focus();
}

checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('select_all');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
}
</script>
<script>document.body.style.overflow = "auto";</script> 
<body>
<h1>{ml_message_list}</h1>
<form action="" method="post" id ="select_all">
<input type="hidden" name="curr" value="{mlst_data_page}">
<input type="hidden" name="pmax" value="{mlst_data_pagemax}">
<input type="hidden" name="sele" value="{mlst_data_sele}">
   	<table width="90%" border="0" cellspacing="1" cellpadding="1">   
		<tr>
            <td class="c">{ml_page}</td>
            <td class="c">{ml_type}</td>
        	<td class="c">{ml_dlte_since}</td>
        </tr>
		<tr>
            <th>
            <select name="page" onChange="submit();">
            {mlst_data_pages}
            </select>
            </th>
            <th>
            <select name="type" onChange="submit();">
            {mlst_data_types}
            </select>
            </th>
			<th>
			<input type="text" name="selday" value="dd" size="3" maxlength="2" /> 
			<input type="text" name="selmonth"  value="mm" size="3"  maxlength="2"/> 
			<input type="text" value="yyyy" name="selyear" size="6"  maxlength="4"/></th>
        </tr> 
		<tr>
            <th><input type="submit" name="prev" value="[ &lt;- ]" />&nbsp;<input type="submit" name="next" value="[ -&gt; ]" /></th>
            <th>&nbsp;</td>
        	<th>&nbsp;</th>
        </tr>   
        <tr>
            <th><input type="button" name="checkall" onClick="checkedAll(select_all);" value="{ml_select_all_messages}"></th>
			<th><input type="submit" name="delsel" value="{ml_dlte_selection}" /></th>
			<th><input type="submit" name="deldat" value="{ml_dlte_since_button}" /></th>
        </tr>
        <tr>
            <th colspan="3">
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr align="center">
                        <td class="c">&nbsp;</td>
                        <td class="c">{ml_id}</td>
                        <td class="c">{ml_date}</td>
                        <td class="c">{ml_from}</td>
                        <td class="c">{ml_to}</td>
						<td width="15%" class="c">{ml_subject}</td>
                        <td width="60%" class="c">{ml_content}</td>
                    </tr>
                    {mlst_data_rows}
                </table>
        	</th>
        </tr>
    </table>
</form>
</body>