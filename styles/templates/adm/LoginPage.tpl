{include file="overall_header.tpl"}
<div id="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <th>{$LNG.adm_login}</th>
        </tr>
		<tr>
            <td>
				<div><label style="display:inline-block;width:100px;">{$LNG.adm_username}:</label><input type="text" readonly value="{$username}"></div>
				<div><label style="display:inline-block;width:100px;">{$LNG.adm_password}:</label><input type="password" name="admin_pw"></div>
				<div><input type="submit" value="{$LNG.adm_absenden}"></div>
			</td>
        </tr>
    </table>
	</form>
</div>
{include file="overall_footer.tpl"}