{include file="overall_header.tpl"}
<div id="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <th>{lang}adm_login{/lang}</th>
        </tr>
		<tr>
            <td>
				<div><label style="display:inline-block;width:100px;">{lang}adm_username{/lang}:</label><input type="text" readonly value="{$username}"></div>
				<div><label style="display:inline-block;width:100px;">{lang}adm_password{/lang}:</label><input type="password" name="admin_pw"></div>
				<div><input type="submit" value="{lang}adm_absenden{/lang}"></div>
			</td>
        </tr>
    </table>
	</form>
</div>
{include file="overall_footer.tpl"}