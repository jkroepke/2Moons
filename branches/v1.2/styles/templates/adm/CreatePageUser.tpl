{include file="adm/overall_header.tpl"}
<form action="" method="post">
<table width="45%">
<tr><td class="c" colspan="2">{$new_title}</td></tr>
<tr><th>{$user_reg}</th><th><input type="text" name="name"></th></tr>
<tr><th>{$pass_reg}</th><th><input type="password" name="password"></th></tr>
<tr><th>{$pass2_reg}</th><th><input type="password" name="password2"></th></tr>
<tr><th>{$email_reg}</th><th><input type="text" name="email"></th></tr>
<tr><th>{$email2_reg}</th><th><input type="text" name="email2"></th></tr>
<tr><th>{$new_coord}</th><th>
<input type="text" name="galaxy" size="1" maxlength="1"> :
<input type="text" name="system" size="3" maxlength="3"> :
<input type="text" name="planet" size="2" maxlength="2"></th></tr>
<tr><th>{$new_range}</th>
<th>{html_options name=authlevel options=$Selector}</th></tr>
<tr><th colspan="2"><input type="submit" value="{$new_add_user}"></th></tr>
<tr>
   <th colspan="2" style="text-align:left;"><a href="?page=create">{$new_creator_go_back}</a>&nbsp;<a href="?page=create&amp;mode=user">{$new_creator_refresh}</a></th>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}