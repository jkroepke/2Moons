{include file="install/ins_header.tpl"}
<tr>
	<td class="left">
		<h2>{lang}step1_head{/lang}</h2>
		<p>{lang}step1_desc{/lang}</p>
		<form action="index.php?mode=ins&page=2&lang={$lang}" method="post"> 
		<input type="hidden" name="post" value="1">
		<table class="req">
			<tr>
				<td class="transparent left">{lang}step1_mysql_server{/lang}</td>
				<td class="transparent"><input type="text" name="host" value="localhost" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}step1_mysql_port{/lang}</td>
				<td class="transparent"><input type="text" name="port" value="3306" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}step1_mysql_dbname{/lang}</td>
				<td class="transparent"><input type="text" name="db" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}step1_mysql_dbuser{/lang}</td>
				<td class="transparent"><input type="text" name="user" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}step1_mysql_dbpass{/lang}</td>
				<td class="transparent"><input type="password" name="passwort" value="" size="30"></td>
			</tr>
			<tr>
				<td class="transparent left">{lang}step1_mysql_prefix{/lang}</td>
				<td class="transparent"><input type="text" name="prefix" value="uni1_" size="30"></td>
			</tr>
			<tr class="noborder">
				<td colspan="2" class="transparent"><input type="submit" name="next" value="{lang}continue{/lang}"></td>
			</tr>
		</table>
		</form>
	</td>
</tr>
{include file="install/ins_footer.tpl"}