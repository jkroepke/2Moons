{extends file="index.tpl"}
{block name="title" prepend}{$menu_index}{/block}
{block name="content"}
<section>
	<h1>{$welcome_to} {$servername}</h1>
	<p class="desc">{$server_description}</p>
	<p class="desc"><ul id="desc_list">{foreach item=InfoRow from=$server_infos}<li>{$InfoRow}</li>{/foreach}</ul>
</section>
<section>
	<div id="contentbox">
		<div class="no"><div class="ne"><div class="n"></div></div>
			<div class="o"><div class="e"><div class="c">
				<div id="loginbox"><h3>{$login}</h3>
					<form id="login" name="login" action="index.php" method="post" onsubmit="return Submit('login');">
						<label for="universe">{$universe}</label><select name="universe" id="universe">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="username">{$user}</label><input name="username" id="username" type="text"><br>
						<label for="password">{$pass}</label><input name="password" id="password" type="password"><br>
						<input name="submit" value="{$login}" type="submit">
					</form>
					{if $fb_active}<br><a href="javascript:initFB();"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a><br>{/if}
					<br><span class="small">{$login_info}</span>
				</div>
				<div id="regbox"><h3>{$register}</h3>
					<form id="reg" name="reg" action="index.php?page=reg&amp;action=send" method="post" onsubmit="return SubmitReg();">
						<label for="reg_universe">{$universe}</label><select name="universe" id="reg_universe">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="reg_username">{$user}</label><input name="username" id="reg_username" type="text"><br>
						<label for="reg_password">{$pass}</label><input name="password" id="reg_password" type="password"><br>
						<label for="reg_password_2">{$pass_2}</label><input name="password_2" id="reg_password_2" type="password"><br>
						<label for="reg_email">{$email}</label><input name="email" id="reg_email" type="text"><br>
						<label for="reg_email_2">{$email_2}</label><input name="email_2" id="reg_email_2" type="text"><br>
						<label for="reg_planet">{$planetname}</label><input name="planet" id="reg_planet" type="text"><br>
						<label for="reg_lang">{$language}</label><select name="lang" id="reg_lang">{html_options options=$AvailableLangs selected=$lang}</select><br>
						{if $game_captcha}
						<div id="recaptcha_image"></div>
						<label for="reg_captcha">{$captcha_reg}</label><input type="text" id="recaptcha_response_field" name="recaptcha_response_field"><br>
						{/if}
						<input name="submit" value="{$register}" type="submit">
					</form>
					{if $fb_active}<br><a href="javascript:initFB();"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a><br>{/if}
				</div>
				<div id="lostbox"><h3>{$lostpassword}</h3>
					<form id="lost" name="lost" action="index.php" method="post" onsubmit="return SubmitLogin();">
						<label for="universe_lost">{$universe}</label><select name="universe" id="universe_lost">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="username_lost">{$user}</label><input name="username" id="username_lost" type="text"><br>
						<label for="email_lost">{$email}</label><input name="password" id="email_lost" type="text"><br>
						<input name="submit" value="{$login}" type="submit">
					</form>
				</div>
			</div></div></div>
			<div>
			<div class="so"><div class="se"><div class="s"></div></div></div>
			</div>
		</div>
	</div>
</section>
<section>
	<table class="box">
		<tr class="box-header">
			<td class="box-header-left"></td><td class="box-header-center"></td><td class="box-header-right"></td>
		</tr>
		<tr class="box-content"><td class="box-content-left"></td><td class="box-content-center">
				<a href="#" onclick="return Content('login');" class="multi">
					<table class="button-important"><tr><td class="button-left"></td><td class="button-center">
						{$login}
					</td><td class="button-right"></td></tr></table></a>
				<a href="#" onclick="return Content('register');" class="multi">
					<table class="button-important"><tr><td class="button-left"></td><td class="button-center">
						{$register_now}
					</td><td class="button-right"></td></tr></table></a>
				</td>
			<td class="box-content-right"></td></tr>
		<tr class="box-footer">
			<td class="box-footer-left"></td><td class="box-footer-center"></td><td class="box-footer-right"></td>
		</tr>
	</table>
	<table class="box">
		<tr><td>
			<table class="box-header"><tr><td class="box-header-left"></td><td class="box-header-center"></td><td class="box-header-right"></td></tr></table>
		</td></tr>
		<tr><td>
			<table class="box-content"><tr><td class="box-content-left"></td><td class="box-content-center">
				<a href="#" onclick="return Content('lost');" class="multi"><table class="button button-multi"><tr>
					<td class="button-left"></td><td class="button-center">
						{$lostpassword}
				</td><td class="button-right"></td></tr></table></a>
				<a href="index.php?page=screens" class="multi"><table class="button button-multi"><tr>
					<td class="button-left"></td><td class="button-center">
						{$screenshots}
					</td><td class="button-right"></td></tr></table></a>
				</td><td class="box-content-right"></td></tr>
			</table>
		</td></tr>
		<tr><td>
			<table class="box-footer"><tr><td class="box-footer-left"></td><td class="box-footer-center"></td><td class="box-footer-right"></td></tr></table>
		</td></tr>
	</table>
</section>
{/block}