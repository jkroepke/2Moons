{block name="title" prepend}{$LNG.lo_head}{/block}
{block name="content"}
<div id="content">
	<form action="" method="POST">
    <table style="width:569px;margin-top:30px;">
		<tr>
            <th>{$LNG.lo_head}</th>
        </tr>
		<tr>
            <td>
				<div><p>{$LNG.lo_info}</p></div>
				<div><label style="display:inline-block;width:100px;" for="username">{$LNG.lo_username}:</label><input type="text" readonly value="{$username}" id="username"></div>
				<div><label style="display:inline-block;width:100px;" for="password">{$LNG.lo_password}:</label><input type="password" name="password" id="password"></div>
				<div><input type="submit" value="{$LNG.button_send}"></div>
			</td>
        </tr>
    </table>
	</form>
</div>
{/block}