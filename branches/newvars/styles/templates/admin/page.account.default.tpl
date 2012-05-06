{block name="title" prepend}{$LNG.ed_user_head}{/block}
{block name="content"}
<form action="admin.php?page=account" method="post">
<input type="hidden" name="mode" value="detailUser">
<table>
	<tr>
		<th>{$LNG.ed_user_head}</th>
	</tr>
	<tr>
		<td>{$LNG.ed_user_info}</td>
	</tr>
	<tr>
		<td><input type="text" id="username"></td>
	</tr>
	<tr>
		<td><select size="10" style="width:300px" name="id">
		{foreach $userList as $userID => $userRow}
		<option value="{$userID}">[ID: {$userID}] {$userRow.username}</option>
		{/foreach}
		</select></td>
	</tr>
	<tr>
		<td><input type="submit" value="{$LNG.common_submit}"></td>
	</tr>
</table>
</form>
{/block}