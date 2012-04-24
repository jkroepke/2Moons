{block name="title" prepend}{$LNG.adm_login}{/block}
{block name="content"}
<div id="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <th>{$LNG.adm_login}</th>
        </tr>
		<tr>
            <td>
				<div><label style="display:inline-block;width:100px;" for="username">{$LNG.adm_username}:</label><input type="text" readonly value="{$username}" id="username"></div>
				<div><label style="display:inline-block;width:100px;" for="password">{$LNG.adm_password}:</label><input type="password" name="password" id="password"></div>
				<div><input type="submit" value="{$LNG.adm_absenden}"></div>
			</td>
        </tr>
    </table>
	</form>
</div>
{/block}