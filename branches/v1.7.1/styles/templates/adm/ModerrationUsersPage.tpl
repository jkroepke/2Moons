
<form action="" method="post" name="users">
{include file="overall_header.tpl"}
<table width="55%">
<tr>
	<th colspan="7">{$ad_authlevel_title}</th>
</tr><tr>
	<td colspan="2">
	<select name="id_1" size="20" style="width:80%;">
		{$UserList}
	</select>
	
	<script type="text/javascript">
		var UserList = new filterlist(document.getElementsByName('id_1')[0]);
	</script>
	<br>
	<a href="?page=rights&amp;mode=users&amp;sid={$sid}&amp;get=adm">{$ad_authlevel_aa}</a>&nbsp;
	<a href="?page=rights&amp;mode=users&amp;sid={$sid}&amp;get=ope">{$ad_authlevel_oo}</a>&nbsp;
	<a href="?page=rights&amp;mode=users&amp;sid={$sid}&amp;get=mod">{$ad_authlevel_mm}</a>&nbsp;
	<a href="?page=rights&amp;mode=users&amp;sid={$sid}&amp;get=pla">{$ad_authlevel_jj}</a>&nbsp;
	<a href="?page=rights&amp;mode=users&amp;sid={$sid}">{$ad_authlevel_tt}</a>&nbsp;
	<br><br>
	<A HREF="javascript:UserList.set('^A')" TITLE="{$bo_select_title} A">A</A>
	<A HREF="javascript:UserList.set('^B')" TITLE="{$bo_select_title} B">B</A>
	<A HREF="javascript:UserList.set('^C')" TITLE="{$bo_select_title} C">C</A>
	<A HREF="javascript:UserList.set('^D')" TITLE="{$bo_select_title} D">D</A>

	<A HREF="javascript:UserList.set('^E')" TITLE="{$bo_select_title} E">E</A>
	<A HREF="javascript:UserList.set('^F')" TITLE="{$bo_select_title} F">F</A>
	<A HREF="javascript:UserList.set('^G')" TITLE="{$bo_select_title} G">G</A>
	<A HREF="javascript:UserList.set('^H')" TITLE="{$bo_select_title} H">H</A>
	<A HREF="javascript:UserList.set('^I')" TITLE="{$bo_select_title} I">I</A>
	<A HREF="javascript:UserList.set('^J')" TITLE="{$bo_select_title} J">J</A>
	<A HREF="javascript:UserList.set('^K')" TITLE="{$bo_select_title} K">K</A>
	<A HREF="javascript:UserList.set('^L')" TITLE="{$bo_select_title} L">L</A>
	<A HREF="javascript:UserList.set('^M')" TITLE="{$bo_select_title} M">M</A>

	<A HREF="javascript:UserList.set('^N')" TITLE="{$bo_select_title} N">N</A>
	<A HREF="javascript:UserList.set('^O')" TITLE="{$bo_select_title} O">O</A>
	<A HREF="javascript:UserList.set('^P')" TITLE="{$bo_select_title} P">P</A>
	<A HREF="javascript:UserList.set('^Q')" TITLE="{$bo_select_title} Q">Q</A>
	<A HREF="javascript:UserList.set('^R')" TITLE="{$bo_select_title} R">R</A>
	<A HREF="javascript:UserList.set('^S')" TITLE="{$bo_select_title} S">S</A>
	<A HREF="javascript:UserList.set('^T')" TITLE="{$bo_select_title} T">T</A>
	<A HREF="javascript:UserList.set('^U')" TITLE="{$bo_select_title} U">U</A>
	<A HREF="javascript:UserList.set('^V')" TITLE="{$bo_select_title} V">V</A>

	<A HREF="javascript:UserList.set('^W')" TITLE="{$bo_select_title} W">W</A>
	<A HREF="javascript:UserList.set('^X')" TITLE="{$bo_select_title} X">X</A>
	<A HREF="javascript:UserList.set('^Y')" TITLE="{$bo_select_title} Y">Y</A>
	<A HREF="javascript:UserList.set('^Z')" TITLE="{$bo_select_title} Z">Z</A>

	<BR>
	<INPUT NAME="regexp" onKeyUp="UserList.set(this.value)">
	<INPUT TYPE="button" onClick="UserList.set(this.form.regexp.value)" value="{$button_filter}">
	<INPUT TYPE="button" onClick="UserList.reset();this.form.regexp.value=''" value="{$button_deselect}">
	</td>
</tr><tr>
	<td>{$ad_authlevel_insert_id}</td>
	<td><input name="id_2" type="text" size="5"></td>
</tr><tr>
	<td>{$ad_authlevel_auth}</td>
	<td>{html_options name=authlevel options=$Selector}</td>
</tr><tr>
	<td colspan="3"><input type="submit" value="{$button_submit}"></td>
</tr>
</table>
{include file="overall_footer.tpl"}