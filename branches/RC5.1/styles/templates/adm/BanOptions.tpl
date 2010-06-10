<script>document.body.style.overflow = "auto";</script>
<SCRIPT TYPE="text/javascript" SRC="../scripts/filterlist.js"></SCRIPT>
<body>
<form action="" method="get" name="users">
<table width="100%" style="background:url(images/Adm/blank.gif);" border="0px">
<td style="border:0px;">
<table align="center" width="90%">
{display}
<tr>
	<td class="c" colspan="4">{bo_ban_player}</td>
</tr>
<tr>
	<th colspan="2">
	<select name="ban_name" style="width:70%;" size="20">
	{List}
	</select>
	<BR>
	<a href="BanPage.php">{bo_order_username}</a> &nbsp; <a href="BanPage.php?order=id">{bo_order_id}</a> &nbsp; 
	<a href="BanPage.php?view=bana">{bo_order_banned}</a>
	<SCRIPT TYPE="text/javascript">
	<!--
		var UserList = new filterlist(document.users.ban_name);
	//-->
	</SCRIPT>
	
	<BR><BR>
	<A HREF="javascript:UserList.set('^A')" TITLE="{bo_select_title} A">A</A>
	<A HREF="javascript:UserList.set('^B')" TITLE="{bo_select_title} B">B</A>
	<A HREF="javascript:UserList.set('^C')" TITLE="{bo_select_title} C">C</A>
	<A HREF="javascript:UserList.set('^D')" TITLE="{bo_select_title} D">D</A>

	<A HREF="javascript:UserList.set('^E')" TITLE="{bo_select_title} E">E</A>
	<A HREF="javascript:UserList.set('^F')" TITLE="{bo_select_title} F">F</A>
	<A HREF="javascript:UserList.set('^G')" TITLE="{bo_select_title} G">G</A>
	<A HREF="javascript:UserList.set('^H')" TITLE="{bo_select_title} H">H</A>
	<A HREF="javascript:UserList.set('^I')" TITLE="{bo_select_title} I">I</A>
	<A HREF="javascript:UserList.set('^J')" TITLE="{bo_select_title} J">J</A>
	<A HREF="javascript:UserList.set('^K')" TITLE="{bo_select_title} K">K</A>
	<A HREF="javascript:UserList.set('^L')" TITLE="{bo_select_title} L">L</A>
	<A HREF="javascript:UserList.set('^M')" TITLE="{bo_select_title} M">M</A>

	<A HREF="javascript:UserList.set('^N')" TITLE="{bo_select_title} N">N</A>
	<A HREF="javascript:UserList.set('^O')" TITLE="{bo_select_title} O">O</A>
	<A HREF="javascript:UserList.set('^P')" TITLE="{bo_select_title} P">P</A>
	<A HREF="javascript:UserList.set('^Q')" TITLE="{bo_select_title} Q">Q</A>
	<A HREF="javascript:UserList.set('^R')" TITLE="{bo_select_title} R">R</A>
	<A HREF="javascript:UserList.set('^S')" TITLE="{bo_select_title} S">S</A>
	<A HREF="javascript:UserList.set('^T')" TITLE="{bo_select_title} T">T</A>
	<A HREF="javascript:UserList.set('^U')" TITLE="{bo_select_title} U">U</A>
	<A HREF="javascript:UserList.set('^V')" TITLE="{bo_select_title} V">V</A>

	<A HREF="javascript:UserList.set('^W')" TITLE="{bo_select_title} W">W</A>
	<A HREF="javascript:UserList.set('^X')" TITLE="{bo_select_title} X">X</A>
	<A HREF="javascript:UserList.set('^Y')" TITLE="{bo_select_title} Y">Y</A>
	<A HREF="javascript:UserList.set('^Z')" TITLE="{bo_select_title} Z">Z</A>
	<BR>
	<INPUT NAME="regexp" onKeyUp="UserList.set(this.value)">
	<INPUT TYPE="button" onClick="UserList.set(this.form.regexp.value)" value="{button_filter}">
	<INPUT TYPE="button" onClick="UserList.reset();this.form.regexp.value=''" value="{button_deselect}">
</th>
</tr><tr>
	<th colspan="2">
	<input type="submit" value="{button_submit}" name="panel" style="width:20%;"/>&nbsp;
	<INPUT TYPE="button" onClick="UserList.reset();this.form.regexp.value=''" value="{button_reset}">
	</th>
</tr><tr>
	<th colspan="2" align="left">
		{bo_total_users}{userss}
	</th>
</tr>
</table>
</form>
</td>
<td style="border:0px;">
<br />
<form action="" method="POST" name="userban">
<table align="center" width="90%">
{display2}
<tr>
	<td class="c" colspan="2">{bo_unban_player}</td>
</tr>
<tr>
	<th colspan="2">
	<select name="unban_name" size="20" style="width:70%;">
	{ListBan}
	</select>
	<BR>
	<a href="BanPage.php">{bo_order_username}</a> &nbsp; <a href="BanPage.php?order2=id">{bo_order_id}</a>
	<SCRIPT TYPE="text/javascript">
	<!--
		var UsersBan = new filterlist(document.userban.unban_name);
	//-->
	</SCRIPT>
	
	<BR><BR>
	<A HREF="javascript:UsersBan.set('^A')" TITLE="{bo_select_title} A">A</A>
	<A HREF="javascript:UsersBan.set('^B')" TITLE="{bo_select_title} B">B</A>
	<A HREF="javascript:UsersBan.set('^C')" TITLE="{bo_select_title} C">C</A>
	<A HREF="javascript:UsersBan.set('^D')" TITLE="{bo_select_title} D">D</A>

	<A HREF="javascript:UsersBan.set('^E')" TITLE="{bo_select_title} E">E</A>
	<A HREF="javascript:UsersBan.set('^F')" TITLE="{bo_select_title} F">F</A>
	<A HREF="javascript:UsersBan.set('^G')" TITLE="{bo_select_title} G">G</A>
	<A HREF="javascript:UsersBan.set('^H')" TITLE="{bo_select_title} H">H</A>
	<A HREF="javascript:UsersBan.set('^I')" TITLE="{bo_select_title} I">I</A>
	<A HREF="javascript:UsersBan.set('^J')" TITLE="{bo_select_title} J">J</A>
	<A HREF="javascript:UsersBan.set('^K')" TITLE="{bo_select_title} K">K</A>
	<A HREF="javascript:UsersBan.set('^L')" TITLE="{bo_select_title} L">L</A>
	<A HREF="javascript:UsersBan.set('^M')" TITLE="{bo_select_title} M">M</A>

	<A HREF="javascript:UsersBan.set('^N')" TITLE="{bo_select_title} N">N</A>
	<A HREF="javascript:UsersBan.set('^O')" TITLE="{bo_select_title} O">O</A>
	<A HREF="javascript:UsersBan.set('^P')" TITLE="{bo_select_title} P">P</A>
	<A HREF="javascript:UsersBan.set('^Q')" TITLE="{bo_select_title} Q">Q</A>
	<A HREF="javascript:UsersBan.set('^R')" TITLE="{bo_select_title} R">R</A>
	<A HREF="javascript:UsersBan.set('^S')" TITLE="{bo_select_title} S">S</A>
	<A HREF="javascript:UsersBan.set('^T')" TITLE="{bo_select_title} T">T</A>
	<A HREF="javascript:UsersBan.set('^U')" TITLE="{bo_select_title} U">U</A>
	<A HREF="javascript:UsersBan.set('^V')" TITLE="{bo_select_title} V">V</A>

	<A HREF="javascript:UsersBan.set('^W')" TITLE="{bo_select_title} W">W</A>
	<A HREF="javascript:UsersBan.set('^X')" TITLE="{bo_select_title} X">X</A>
	<A HREF="javascript:UsersBan.set('^Y')" TITLE="{bo_select_title} Y">Y</A>
	<A HREF="javascript:UsersBan.set('^Z')" TITLE="{bo_select_title} Z">Z</A>

	<BR>
	<INPUT NAME="regexp" onKeyUp="UsersBan.set(this.value)">
	<INPUT TYPE="button" onClick="UsersBan.set(this.form.regexp.value)" value="{button_filter}">
	<INPUT TYPE="button" onClick="UsersBan.set(this.form.regexp.value)" value="{button_deselect}">
</th>
</tr>
<tr>
	<th colspan="2"><input value="{button_submit}" type="submit" style="width:20%;">&nbsp;
	<INPUT TYPE="button" onClick="UsersBan.reset();this.form.regexp.value=''" value="{button_reset}"></th>
</tr><tr>
	<th colspan="2" align="left">
		{bo_total_banneds}{banneds}
	</th>
</tr>
</table>
</form>
</td>
</table>
</body>