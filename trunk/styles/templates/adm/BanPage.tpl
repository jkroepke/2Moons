{include file="adm/overall_header.tpl"}
{if $name}
<form action="" method="post" name="countt">
<table width="50%">
<tr>
	<th colspan="3">{$bantitle}</th>
</tr><tr>
	<td>{$bo_username}</td>
	<td colspan="2"><input name="ban_name" type="text" value="{$name}" readonly="true" class="character"/></td>
</tr><tr>
	<td>{$bo_reason} <br><br>{$bo_characters_1}<input id="result2" value="50" size="2" readonly="true" class="character"></td> 
	<td colspan="2"><textarea name="why" maxlengtd="50" cols="20" rows="5" onkeyup="$('#result2').val(50 - parseInt($(tdis).val().lengtd));">{$reas}</textarea></td>
</tr>
	{$timesus}
<tr>
	<th colspan="2">{$changedate}</th>
	{$changedate_advert}
</tr><tr>
	<td>{$time_days}</td>
	<td><input name="days" type="text" value="0" size="5"></td>
	{if $changedate_advert}<td>&nbsp;</td>{/if}
</tr><tr>
	<td>{$time_hours}</td>
	<td><input name="hour" type="text" value="0" size="5"></td>
	{if $changedate_advert}<td>&nbsp;</td>{/if}
</tr><tr>
	<td>{$time_minutes}</td>
	<td><input name="mins" type="text" value="0" size="5"></td>
	{if $changedate_advert}<td>&nbsp;</td>{/if}
</tr><tr>
	<td>{$time_seconds}</td>
	<td><input name="secs" type="text" value="0" size="5"></td>
	{if $changedate_advert}<td>&nbsp;</td>{/if}
</tr><tr>
	<th colspan="3">{$bo_vacaations}</th>
</tr><tr>
	<td>{$bo_vacation_mode}</td>
	<td colspan="2"><input name="vacat" type="checkbox"{if $vacation} checked = "checked"{/if}></td>
</tr><tr>
	<td colspan="3">
	<input type="submit" value="{$button_submit}" name="bannow" style="width:20%;"/>
</tr>
</table>
</form>
{/if}
<form action="" method="POST" name="users">
<table width="100%" border="0px">
<td style="border:0px;width:50%">
<table align="center" width="90%">
<tr>
	<th colspan="4">{$bo_ban_player}</th>
</tr>
<tr>
	<td colspan="2">
	<select name="ban_name" style="width:70%;" size="20">
	{$UserSelect.List}
	</select>
	<br>
	<a href="?page=bans">{$bo_order_username}</a> &nbsp; <a href="?page=bans&amp;order=id">{$bo_order_id}</a> &nbsp; 
	<a href="?page=bans&amp;view=bana">{$bo_order_banned}</a>
	<script TYPE="text/javascript">
		var UserList = new filterlist(document.getElementsByName('ban_name')[0]);
	</script>
	
	<br><br>
	<a href="javascript:UserList.set('^A')" title="{$bo_select_title} A">A</A>
	<a href="javascript:UserList.set('^B')" title="{$bo_select_title} B">B</A>
	<a href="javascript:UserList.set('^C')" title="{$bo_select_title} C">C</A>
	<a href="javascript:UserList.set('^D')" title="{$bo_select_title} D">D</A>

	<a href="javascript:UserList.set('^E')" title="{$bo_select_title} E">E</A>
	<a href="javascript:UserList.set('^F')" title="{$bo_select_title} F">F</A>
	<a href="javascript:UserList.set('^G')" title="{$bo_select_title} G">G</A>
	<a href="javascript:UserList.set('^H')" title="{$bo_select_title} H">H</A>
	<a href="javascript:UserList.set('^I')" title="{$bo_select_title} I">I</A>
	<a href="javascript:UserList.set('^J')" title="{$bo_select_title} J">J</A>
	<a href="javascript:UserList.set('^K')" title="{$bo_select_title} K">K</A>
	<a href="javascript:UserList.set('^L')" title="{$bo_select_title} L">L</A>
	<a href="javascript:UserList.set('^M')" title="{$bo_select_title} M">M</A>

	<a href="javascript:UserList.set('^N')" title="{$bo_select_title} N">N</A>
	<a href="javascript:UserList.set('^O')" title="{$bo_select_title} O">O</A>
	<a href="javascript:UserList.set('^P')" title="{$bo_select_title} P">P</A>
	<a href="javascript:UserList.set('^Q')" title="{$bo_select_title} Q">Q</A>
	<a href="javascript:UserList.set('^R')" title="{$bo_select_title} R">R</A>
	<a href="javascript:UserList.set('^S')" title="{$bo_select_title} S">S</A>
	<a href="javascript:UserList.set('^T')" title="{$bo_select_title} T">T</A>
	<a href="javascript:UserList.set('^U')" title="{$bo_select_title} U">U</A>
	<a href="javascript:UserList.set('^V')" title="{$bo_select_title} V">V</A>

	<a href="javascript:UserList.set('^W')" title="{$bo_select_title} W">W</A>
	<a href="javascript:UserList.set('^X')" title="{$bo_select_title} X">X</A>
	<a href="javascript:UserList.set('^Y')" title="{$bo_select_title} Y">Y</A>
	<a href="javascript:UserList.set('^Z')" title="{$bo_select_title} Z">Z</A>
	<br>
	<input NAME="regexp" onKeyUp="UserList.set(tdis.value)">
	<input TYPE="button" onClick="UserList.set(tdis.form.regexp.value)" value="{$button_filter}">
	<input TYPE="button" onClick="UserList.reset();tdis.form.regexp.value=''" value="{$button_deselect}">
</td>
</tr><tr>
	<td colspan="2">
	<input type="submit" value="{$button_submit}" name="panel" style="width:20%;">&nbsp;
	<input TYPE="button" onClick="UserList.reset();tdis.form.regexp.value=''" value="{$button_reset}">
	</td>
</tr><tr>
	<td colspan="2" align="left">
		{$bo_total_users}<span style="color:lime">{$usercount}</span>
	</td>
</tr>
</table>
</form>
</td>
<td style="border:0px;width:50%;">
<br>
<form action="" method="POST" name="userban">
<table align="center" width="90%">
<tr>
	<th colspan="2">{$bo_unban_player}</th>
</tr>
<tr>
	<td colspan="2">
	<select name="unban_name" size="20" style="width:70%;">
	{$UserSelect.ListBan}
	</select>
	<br>
	<a href="?page=bans">{$bo_order_username}</a> &nbsp; <a href="?page=bans&amp;order2=id">{$bo_order_id}</a>
	<script TYPE="text/javascript">
		var UsersBan = new filterlist(document.getElementsByName('unban_name')[0]);
	</script>
	
	<br><br>
	<a href="javascript:UsersBan.set('^A')" title="{$bo_select_title} A">A</A>
	<a href="javascript:UsersBan.set('^B')" title="{$bo_select_title} B">B</A>
	<a href="javascript:UsersBan.set('^C')" title="{$bo_select_title} C">C</A>
	<a href="javascript:UsersBan.set('^D')" title="{$bo_select_title} D">D</A>

	<a href="javascript:UsersBan.set('^E')" title="{$bo_select_title} E">E</A>
	<a href="javascript:UsersBan.set('^F')" title="{$bo_select_title} F">F</A>
	<a href="javascript:UsersBan.set('^G')" title="{$bo_select_title} G">G</A>
	<a href="javascript:UsersBan.set('^H')" title="{$bo_select_title} H">H</A>
	<a href="javascript:UsersBan.set('^I')" title="{$bo_select_title} I">I</A>
	<a href="javascript:UsersBan.set('^J')" title="{$bo_select_title} J">J</A>
	<a href="javascript:UsersBan.set('^K')" title="{$bo_select_title} K">K</A>
	<a href="javascript:UsersBan.set('^L')" title="{$bo_select_title} L">L</A>
	<a href="javascript:UsersBan.set('^M')" title="{$bo_select_title} M">M</A>

	<a href="javascript:UsersBan.set('^N')" title="{$bo_select_title} N">N</A>
	<a href="javascript:UsersBan.set('^O')" title="{$bo_select_title} O">O</A>
	<a href="javascript:UsersBan.set('^P')" title="{$bo_select_title} P">P</A>
	<a href="javascript:UsersBan.set('^Q')" title="{$bo_select_title} Q">Q</A>
	<a href="javascript:UsersBan.set('^R')" title="{$bo_select_title} R">R</A>
	<a href="javascript:UsersBan.set('^S')" title="{$bo_select_title} S">S</A>
	<a href="javascript:UsersBan.set('^T')" title="{$bo_select_title} T">T</A>
	<a href="javascript:UsersBan.set('^U')" title="{$bo_select_title} U">U</A>
	<a href="javascript:UsersBan.set('^V')" title="{$bo_select_title} V">V</A>

	<a href="javascript:UsersBan.set('^W')" title="{$bo_select_title} W">W</A>
	<a href="javascript:UsersBan.set('^X')" title="{$bo_select_title} X">X</A>
	<a href="javascript:UsersBan.set('^Y')" title="{$bo_select_title} Y">Y</A>
	<a href="javascript:UsersBan.set('^Z')" title="{$bo_select_title} Z">Z</A>

	<br>
	<input NAME="regexp" onKeyUp="UsersBan.set(tdis.value)">
	<input TYPE="button" onClick="UsersBan.set(tdis.form.regexp.value)" value="{$button_filter}">
	<input TYPE="button" onClick="UsersBan.set(tdis.form.regexp.value)" value="{$button_deselect}">
</td>
</tr>
<tr>
	<td colspan="2"><input value="{$button_submit}" type="submit" style="width:20%;">&nbsp;
	<input TYPE="button" onClick="UsersBan.reset();tdis.form.regexp.value=''" value="{$button_reset}"></td>
</tr><tr>
	<td colspan="2" align="left">
		{$bo_total_banneds}<span style="color:lime">{$bancount}</span>
	</td>
</tr>
</table>
</form>
</td>
</table>
{include file="adm/overall_footer.tpl"}