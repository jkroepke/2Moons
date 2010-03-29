<script language="JavaScript">
function f(target_url, win_name) {
var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
new_win.focus();
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
			<input type="text" name="selday" onClick="if(this.value == 'dd') this.value = '';" onBlur="if(this.value == '') this.value= 'dd';" value="dd" size="3" maxlength="2" /> 
			<input type="text" name="selmonth" onClick="if(this.value == 'mm') this.value = '';" onBlur="if(this.value == '') this.value= 'mm';" value="mm" size="3"  maxlength="2"/> 
			<input type="text" name="selyear" onClick="if(this.value == 'yyyy') this.value = '';" onBlur="if(this.value == '') this.value= 'yyyy';" value="yyyy" size="6"  maxlength="4"/></th>
        </tr> 
		<tr>
            <th><input type="submit" name="prev" value="[ &lt;- ]" />&nbsp;<input type="submit" name="next" value="[ -&gt; ]" /></th>
            <th><input type="submit" name="delsel" value="{ml_dlte_selection}" /></th>
			<th><input type="submit" name="deldat" value="{ml_dlte_since_button}" /></th>
        </tr>   
        <tr>
            <th colspan="3">
                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <tr align="center">
                        <td class="c"><input title="{button_des_se}" type="checkbox" name="checkall" onClick="checkedAll(select_all);" value="{ml_select_all_messages}"></td>
                        <td class="c">{input_id}</td>
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