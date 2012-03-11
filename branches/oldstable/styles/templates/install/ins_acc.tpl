{include file="ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{lang}step4_head{/lang}</h2>
		<p>{lang}step4_desc{/lang}</p>
		<form action="index.php?step=8" method="post"> 
		<input type="hidden" name="post" value="1">
		<table class="req">
			<tr>
				<td class="transparent left"><p>{lang}step4_admin_name{/lang}</p><p class="desc">{lang}step4_admin_name_desc{/lang}</p></td>
				<td class="transparent"><input type="text" name="username" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step4_admin_pass{/lang}</p><p class="desc">{lang}step4_admin_pass_desc{/lang}</p></td>
				<td class="transparent"><input type="password" name="password" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step4_admin_mail{/lang}</p></td>
				<td class="transparent"><input type="text" name="email" value="" size="30"></td>
			</tr>
			<tr class="noborder">
				<td colspan="2" class="transparent"><input type="submit" name="next" value="{lang}continue{/lang}"></td>
			</tr>
		</table>
		</form>
	</td>
</tr>
{include file="ins_footer.tpl"}