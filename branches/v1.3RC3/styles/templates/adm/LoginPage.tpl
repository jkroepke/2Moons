{include file="adm/overall_header.tpl"}
<div id="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <th>{$adm_login}</th>
        </tr>
		<tr>
            <td>{$adm_password}: <input type="password" name="admin_pw"><br><input type="submit" value="{$adm_absenden}"></td></td>
        </tr>
    </table>
	</form>
</div>
{include file="adm/overall_footer.tpl"}