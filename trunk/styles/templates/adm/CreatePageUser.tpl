{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr><th colspan="2">{$new_title}</th></tr>
<tr><td>{$user_reg}</td><td><input type="text" name="name"></td></tr>
<tr><td>{$pass_reg}</td><td><input type="password" name="password"></td></tr>
<tr><td>{$pass2_reg}</td><td><input type="password" name="password2"></td></tr>
<tr><td>{$email_reg}</td><td><input type="text" name="email"></td></tr>
<tr><td>{$email2_reg}</td><td><input type="text" name="email2"></td></tr>
<tr><td>{$new_coord}</td><td>
<input type="text" name="galaxy" size="1" maxlength="1"> :
<input type="text" name="system" size="3" maxlength="3"> :
<input type="text" name="planet" size="2" maxlength="2"></td></tr>
<tr><td>{$new_range}</td>
<td>{html_options name=authlevel options=$Selector.auth}</td></tr>
<tr><td>{$lang}</td>
<td>{html_options name=lang options=$Selector.lang}</td></tr>
<tr><td colspan="2"><input type="submit" value="{$new_add_user}"></td></tr>
<tr>
   <td colspan="2" style="text-align:left;"><a href="?page=create">{$new_creator_go_back}</a>&nbsp;<a href="?page=create&amp;mode=user">{$new_creator_refresh}</a></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}