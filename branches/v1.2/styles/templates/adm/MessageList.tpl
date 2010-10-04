{include file="adm/overall_header.tpl"}
<script type="text/javascript">
var checked = false;
function checkedAll (frm1) {
	var aa = document.getElementById('select_all');
	if(checked == false)
		checked = true;
	else
		checked = false;
		
	for (var i =0; i < aa.elements.length; i++) 
	{
		aa.elements[i].checked = checked;
	}
}

</script>
<form action="" method="post" id="select_all">
<input type="hidden" name="curr" value="{$ViewPage}">
<input type="hidden" name="pmax" value="{$MaxPage}">
<input type="hidden" name="sele" value="{$Selected}">
   	<table width="90%" border="0" cellspacing="1" cellpadding="1">   
		<tr>
            <td class="c">{$ml_page}</td>
            <td class="c">{$ml_type}</td>
        	<td class="c">{$ml_dlte_since}</td>
        </tr>
		<tr>
            <th>
            <select name="side" onChange="submit();">
            	{html_options options=$Selector.pages selected=$ViewPage}
            </select>
            </th>
            <th>
            <select name="type" onChange="submit();">
            	{html_options options=$Selector.type selected=$Selected}
            </select>
            </th>
			<th>
				<input type="text" name="selday" onClick="if(this.value == 'dd') this.value = '';" onBlur="if(this.value == '') this.value= 'dd';" value="dd" size="3" maxlength="2"> 
				<input type="text" name="selmonth" onClick="if(this.value == 'mm') this.value = '';" onBlur="if(this.value == '') this.value= 'mm';" value="mm" size="3"  maxlength="2"> 
				<input type="text" name="selyear" onClick="if(this.value == 'yyyy') this.value = '';" onBlur="if(this.value == '') this.value= 'yyyy';" value="yyyy" size="6"  maxlength="4">
			</th>
        </tr> 
		<tr>
            <th><input type="submit" name="prev" value="[ <- ]">&nbsp;<input type="submit" name="next" value="[ -&gt; ]"></th>
            <th><input type="submit" name="delsel" value="{$ml_dlte_selection}"></th>
			<th><input type="submit" name="deldat" value="{$ml_dlte_since_button}"></th>
        </tr> 
	</table>
	<table width="90%" border="0" cellspacing="1" cellpadding="1">  	
		<tr align="center">
			<td class="c"><input title="{$button_des_se}" type="checkbox" name="checkall" onClick="checkedAll(select_all);" value="{$ml_select_all_messages}"></td>
			<td class="c">{$input_id}</td>
			<td class="c">{$ml_date}</td>
			<td class="c">{$ml_from}</td>
			<td class="c">{$ml_to}</td>
			<td width="15%" class="c">{$ml_subject}</td>
			<td width="60%" class="c">{$ml_content}</td>
        </tr>
        {foreach item=Message from=$MessagesList}
		<tr>
			<th><input type="checkbox" name="sele[{$Message.id}]"></th>
			<th>{$Message.id}</th>
			<th>{$Message.time}</th>
			<th>{$Message.from}</th>
			<th>{$Message.to}</th>
			<th>{$Message.subject}</th>
			<th>{$Message.text}</th>
		</tr>
		{/foreach}
    </table>
</form>
{include file="adm/overall_footer.tpl"}