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
		<td><input type="text" id="search"></td>
	</tr>
	<tr>
		<td><select size="10" style="width:300px" name="userID" id="userID">
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
{block name="script" append}
<script>
$(function() {
	$('#search').data('option', $.makeArray($('#userID option').map(function() {
		return [[$(this).val(), $(this).text()]];
	}))).on('keyup', function(e) {
		$this = $(this);
	
		$('#userID').empty();
		
		if($this.val().length == 0)
		{
			$.each($('#search').data('option'), function(i, val) {
				$('#userID').append($('<option />').val(val[0]).text(val[1]));
			});
		}
		else if($this.val().substr(0, 1) == '#' && $this.val().length > 1)
		{
			$.each($('#search').data('option'), function(i, val) {
				if(new RegExp("^"+$this.val().substr(1)).test(val[0]))
				{
					$('#userID').append($('<option />').val(val[0]).text(val[1]));
				}
			});
		}
		else
		{
			$.each($('#search').data('option'), function(i, val) {
				if(new RegExp("^"+$this.val(), 'i').test(val[1].replace(/\[ID: [0-9]+\] /, "")))
				{
					$('#userID').append($('<option />').val(val[0]).text(val[1]));
				}
			});		
		}
		
		$('#userID').val(function() {
			return $(this).children(':first').val();
		});
	});
});
</script>
{/block}