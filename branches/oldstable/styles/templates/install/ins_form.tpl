{include file="ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{lang}step1_head{/lang}</h2>
		<p>{lang}step1_desc{/lang}</p>
		<form action="index.php?step=4" method="post"> 
		<input type="hidden" name="post" value="1">
		<table class="req">
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_server{/lang}</p></td>
				<td class="transparent"><input type="text" name="host" value="{$smarty.get.host|escape:'htmlall'|default:'localhost'}" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_port{/lang}</p></td>
				<td class="transparent"><input type="text" name="port" value="{$smarty.get.port|escape:'htmlall'|default:'3306'}" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_dbuser{/lang}</p></td>
				<td class="transparent"><input type="text" name="user" value="{$smarty.get.user|escape:'htmlall'}" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_dbpass{/lang}</p></td>
				<td class="transparent"><input type="password" name="passwort" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_dbname{/lang}</p></td>
				<td class="transparent"><input type="text" name="dbname" value="{$smarty.get.dbname|escape:'htmlall'}" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left"><p>{lang}step1_mysql_prefix{/lang}</p></td>
				<td class="transparent"><input type="text" name="prefix" value="{$smarty.get.prefix|escape:'htmlall'|default:'uni1_'}" size="30"></td>
			</tr>
			<tr class="noborder">
				<td colspan="2" class="transparent"><input type="submit" name="next" value="{lang}continue{/lang}"></td>
			</tr>
		</table>
		</form>
	</td>
</tr>
{include file="ins_footer.tpl"}