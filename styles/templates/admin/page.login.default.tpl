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
				<div>
					<p>{$LNG.lo_info}</p>
					<p>
						<label style="display:inline-block;width:100px;" for="username">{$LNG.lo_username}:</label><input type="text" readonly value="{$username}" id="username"><br>
						<label style="display:inline-block;width:100px;" for="password">{$LNG.lo_password}:</label><input type="password" name="password" id="password">
					</p>
					<p><input type="submit" value="{$LNG.common_submit}"></p>
				</div>
			</td>
        </tr>
    </table>
	</form>
</div>
{/block}