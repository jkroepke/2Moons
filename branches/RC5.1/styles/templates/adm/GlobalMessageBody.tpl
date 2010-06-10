<script src="../scripts/cntchar.js" type="text/javascript"></script>
<style>.character{background-color:#344566;color:lime;text-align:center;border:0px;font-weight:bolder;}</style>
<body>
<form action="?mode=change" method="post" name="nameform">
    <table width="550">
				{display}
			<tr>
                <td class="c" colspan="2">{ma_send_global_message}</th>
            </tr>
            <tr>
                <th>{ma_subject}</th>
                <th><input name="temat" maxlength="100" size="20" value="{ma_none}" type="text"></th>
            </tr>
			<tr>
                <th>{ma_characters}</th>
                <th><input name="result" value=5000 size="4" readonly="true" class="character"></th>
            </tr>
            <tr>
                <th colspan="2"><textarea name="tresc" cols="50" rows="10" onKeyDown="contar('nameform','tresc')" onKeyUp="contar('nameform','tresc')"></textarea></th>
            </tr>
            <tr>
                <th colspan="2"><input value="{button_submit}" type="submit"></th>
            </tr>
    </table>
</form>
</body>