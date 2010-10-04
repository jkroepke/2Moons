
<form action="" method="post" name="users">
{include file="adm/overall_header.tpl"}
<table width="55%">
<tr>
	<td class="c" colspan="7">{$ad_authlevel_title}</td>
</tr><tr>
	<th colspan="2">
	<select name="id_1" size="20" style="width:80%;">
		{$UserList}
	</select>
	
	<script type="text/javascript">
		var UserList = new filterlist(document.getElementsByName('id_1')[0]);
	</script>
	<br>
	<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=adm">{$ad_authlevel_aa}</a>&nbsp;
	<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=ope">{$ad_authlevel_oo}</a>&nbsp;
	<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=mod">{$ad_authlevel_mm}</a>&nbsp;
	<a href="?page=rights&amp;mode=rights&amp;sid={$sid}&amp;get=pla">{$ad_authlevel_jj}</a>&nbsp;
	<a href="?page=rights&amp;mode=rights&amp;sid={$sid}">{$ad_authlevel_tt}</a>&nbsp;
	<br><br>
	<a href="javascript:UserList.set('^A')" title="{$bo_select_title} A">A</a>
	<a href="javascript:UserList.set('^B')" title="{$bo_select_title} B">B</a>
	<a href="javascript:UserList.set('^C')" title="{$bo_select_title} C">C</a>
	<a href="javascript:UserList.set('^D')" title="{$bo_select_title} D">D</a>
	<a href="javascript:UserList.set('^E')" title="{$bo_select_title} E">E</a>
	<a href="javascript:UserList.set('^F')" title="{$bo_select_title} F">F</a>
	<a href="javascript:UserList.set('^G')" title="{$bo_select_title} G">G</a>
	<a href="javascript:UserList.set('^H')" title="{$bo_select_title} H">H</a>
	<a href="javascript:UserList.set('^I')" title="{$bo_select_title} I">I</a>
	<a href="javascript:UserList.set('^J')" title="{$bo_select_title} J">J</a>
	<a href="javascript:UserList.set('^K')" title="{$bo_select_title} K">K</a>
	<a href="javascript:UserList.set('^L')" title="{$bo_select_title} L">L</a>
	<a href="javascript:UserList.set('^M')" title="{$bo_select_title} M">M</a>
	<a href="javascript:UserList.set('^N')" title="{$bo_select_title} N">N</a>
	<a href="javascript:UserList.set('^O')" title="{$bo_select_title} O">O</a>
	<a href="javascript:UserList.set('^P')" title="{$bo_select_title} P">P</a>
	<a href="javascript:UserList.set('^Q')" title="{$bo_select_title} Q">Q</a>
	<a href="javascript:UserList.set('^R')" title="{$bo_select_title} R">R</a>
	<a href="javascript:UserList.set('^S')" title="{$bo_select_title} S">S</a>
	<a href="javascript:UserList.set('^T')" title="{$bo_select_title} T">T</a>
	<a href="javascript:UserList.set('^U')" title="{$bo_select_title} U">U</a>
	<a href="javascript:UserList.set('^V')" title="{$bo_select_title} V">V</a>
	<a href="javascript:UserList.set('^W')" title="{$bo_select_title} W">W</a>
	<a href="javascript:UserList.set('^X')" title="{$bo_select_title} X">X</a>
	<a href="javascript:UserList.set('^Y')" title="{$bo_select_title} Y">Y</a>
	<a href="javascript:UserList.set('^Z')" title="{$bo_select_title} Z">Z</a>

	<BR>
	<INPUT NAME="regexp" onKeyUp="UserList.set(this.value)">
	<INPUT TYPE="button" onClick="UserList.set(this.form.regexp.value)" value="{$button_filter}">
	<INPUT TYPE="button" onClick="UserList.reset();this.form.regexp.value=''" value="{$button_deselect}">
	</th>
</tr>
	<th colspan="3"><input type="submit" value="{$button_submit}"></th>
</tr>
</table>
{include file="adm/overall_footer.tpl"}