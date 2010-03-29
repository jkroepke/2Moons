<script>document.body.style.overflow = "auto";</script>
<SCRIPT TYPE="text/javascript" SRC="../scripts/filterlist.js"></SCRIPT> 
<body>
<form action="" method="GET" name="users">
<table border="0px" style="background:url(images/Adm/blank.gif);" width="60%">
{error}
</table>
<br>
<table width="50%">
<td colspan="3" class="c"><center>{ac_enter_user_id}</center></td>
<tr>
<th>
	<select name="id_u" size="20" style="width:80%;">
		{lista}
	</select>
	
	<SCRIPT TYPE="text/javascript">
		var UserList = new filterlist(document.users.id_u);
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
</tr>
<tr><th height="45"><center>{ac_select_id_num}&nbsp;<input type="text" name="id_u2" size="4"></center></th></tr>
<tr><th colspan="3"><center><input type="Submit" value="{button_submit}" /></center></td></tr>
</table>
</form>
</body>