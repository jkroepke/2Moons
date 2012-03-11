{block name="title" prepend}{$LNG.lm_overview}{/block}
{block name="content"}
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">{$LNG.ov_planet_rename}</a></li>
		<li><a href="#tabs-2">{$LNG.ov_delete_planet}</a></li>
	</ul>
	<div id="tabs-1">
		<label for="name">{$LNG.ov_rename_label}: </label><input class="left" type="text" name="name" id="name" size="25" maxlength="20" autocomplete="off">
		<input type="button" onclick="checkrename()" value="{$LNG.mg_send}">
	</div>
	<div id="tabs-2"><h3 style="margin:0">{$LNG.ov_security_request}</h3>{$ov_security_confirm}<br>
		<label for="password">{$LNG.ov_password}: </label><input class="left" type="password" name="password" id="password" size="25" maxlength="20" autocomplete="off">
		<input type="button" onclick="checkcancel()" value="{$LNG.mg_send}">
	</div>
</div>
{/block}