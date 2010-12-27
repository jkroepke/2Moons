{include file="adm/overall_header.tpl"}
<div id="content" class="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <td class="c">{$adm_login}</td>
        </tr>
		<tr>
            <th>{$adm_password}: <input type="password" name="admin_pw"><br><input type="submit" value="{$adm_absenden}"></th></th>
        </tr>
    </table>
	</form>
</div>
{include file="adm/overall_footer.tpl"}