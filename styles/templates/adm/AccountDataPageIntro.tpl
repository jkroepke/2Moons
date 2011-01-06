{include file="adm/overall_header.tpl"}
<form action="" method="POST" name="users">
<table width="50%">
<th colspan="3">{$ac_enter_user_id}</th>
<tr>
<td>
	<select name="id_u" size="20" style="width:80%;">
		{$Userlist}
	</select>
	
	<SCRIPT type="text/javascript">
		var UserList = new filterlist(document.users.id_u);
	</SCRIPT>
	
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
	<input name="regexp" onKeyUp="UserList.set(this.value)">
	<input type="button" onClick="UserList.set(this.form.regexp.value)" value="{$button_filter}">
	<input type="button" onClick="UserList.reset();this.form.regexp.value=''" value="{$button_deselect}">
</td>
</tr>
<tr><td height="45">{$ac_select_id_num}&nbsp;<input type="text" name="id_u2" size="4"></td></tr>
<tr><td colspan="3"><input type="Submit" value="{$button_submit}"></td></tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}