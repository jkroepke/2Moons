<script>document.body.style.overflow = "auto";</script>
<script src="../scripts/cntchar.js" type="text/javascript"></script>
<style>
.center{text-align:center;}
.character{background-color:#344566;color:lime;text-align:center;border:0px;font-weight:bold;font-size:10px;}
</style>
<body>
<form action="" method="post" name="countt">
<table width="50%">
{display}
<tr>
	<td class="c" colspan="3">{title}</td>
</tr><tr>
	<th>{bo_username}</th>
	<th colspan="2"><input name="ban_name" type="text" value="{name}" readonly="true" class="character"/></th>
</tr><tr>
	<th>{bo_reason} <br><br>{bo_characters_1}<input name="result2" value=50 size="2" readonly="true" class="character"></th> 
	<th colspan="2"><textarea name="why" maxlength="50" cols="20" rows="5" onKeyDown="contar2('countt','why')" onKeyUp="contar2('countt','why')">{reas}</textarea></th>
</tr>
	{timesus}
<tr>
	<td class="c" colspan="2">{changedate}</td>
	{changedate_advert}
</tr><tr>
	<th>{time_days}</th>
	<th><input name="days" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{time_hours}</th>
	<th><input name="hour" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{time_minutes}</th>
	<th><input name="mins" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{time_seconds}</th>
	<th><input name="secs" type="text" value="0" size="5" /></th>
</tr><tr>
	<td class="c" colspan="3">{bo_vacaations}</td>
</tr><tr>
	<th>{bo_vacation_mode}</th>
	<th colspan="2"><input name="vacat" type="checkbox" {vacation}/></th>
</tr><tr>
	<th colspan="3">
	<input type="submit" value="{button_submit}" name="bannow" style="width:20%;"/>
</tr><tr>
	<th colspan="3" align="left"><a href="BanPage.php">{bo_bbb_go_back}</a> &nbsp; <a href="BanPage.php?panel=ban_name&ban_name={name}">{bo_bbb_go_act}</a></th>
</tr>
</table>
</form>
</body>