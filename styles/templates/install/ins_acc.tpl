{include file="ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{$LNG.step4_head}</h2>
		<p>{$LNG.step4_desc}</p>
		<form action="index.php?mode=install&step=8" method="post"> 
		<input type="hidden" name="post" value="1">
		<table class="req">
			<tr>
				<td class="transparent left"><p>{$LNG.step4_admin_name}</p><p class="desc">{$LNG.step4_admin_name_desc}</p></td>
				<td class="transparent"><input type="text" name="username" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.step4_admin_pass}</p><p class="desc">{$LNG.step4_admin_pass_desc}</p></td>
				<td class="transparent"><input type="password" name="password" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{$LNG.step4_admin_mail}</p></td>
				<td class="transparent"><input type="text" name="email" value="" size="30"></td>
			</tr>
			<tr class="noborder">
				<td colspan="2" class="transparent"><input type="submit" name="next" value="{$LNG.continue}"></td>
			</tr>
		</table>
		</form>
	</td>
</tr>
{include file="ins_footer.tpl"}