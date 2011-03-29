{extends file="index.tpl"}
{block name="title" prepend}{$menu_index}{/block}
{block name="content"}
<section>
	<h1>{$welcome_to} {$servername}</h1>
	<p class="desc">{$server_description}</p>
	<p class="desc"><ul id="desc_list">{foreach item=InfoRow from=$server_infos}<li>{$InfoRow}</li>{/foreach}</ul>
</section>
<section>
	<table class="contentbox">
		<tr class="contentbox-header">
			<td class="contentbox-header-left"></td><td class="contentbox-header-center"></td><td class="contentbox-header-right"></td>
		</tr>
		<tr class="contentbox-content">
			<td class="contentbox-content-left"></td><td class="contentbox-content-center">
				<div id="loginbox"><h1>{$login}</h1>
					<form id="login" name="login" action="index.php?page=login&amp;action=send" method="post" onsubmit="return Submit('login');">
						<label for="universe">{$universe}</label><select name="uni" id="universe">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="username">{$user}</label><input name="username" id="username" type="text"><br>
						<label for="password">{$pass}</label><input name="password" id="password" type="password"><br>
						<input name="submit" value="{$login}" type="submit">
					</form>
					{if $fb_active}<a href="javascript:FBlogin();" class="fb_login"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
					<br><span class="small">{$login_info}</span>
				</div>
				<div id="regbox"><h1>{$register}</h1>
					<form id="reg" name="reg" action="index.php?page=reg&amp;action=send" method="post" onsubmit="return Submit('register');">
						{if $fb_active}<input type="hidden" name="fb_id" id="fb_id">{/if}
						{if $ref_active}<input type="hidden" name="ref_id" id="ref_id" value="{$ref_id}>{/if}
						<label for="reg_universe">{$universe}</label><select name="uni" id="reg_universe">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="reg_username">{$user}</label><input name="username" id="reg_username" type="text"><br>
						<label for="reg_password">{$pass}</label><input name="password" id="reg_password" type="password"><br>
						<label for="reg_password_2">{$pass_2}</label><input name="password_2" id="reg_password_2" type="password"><br>
						<label for="reg_email">{$email}</label><input name="email" id="reg_email" type="text"><br>
						<label for="reg_email_2">{$email_2}</label><input name="email_2" id="reg_email_2" type="text"><br>
						<label for="reg_planet">{$planetname}</label><input name="planetname" id="reg_planet" type="text"><br>
						<label for="reg_lang">{$language}</label><select name="lang" id="reg_lang" class="lang"></select><br>
						{if $game_captcha}
						<div id="recaptcha_image"></div>
						<label for="recaptcha_response_field">{$captcha_reg}</label><input type="text" id="recaptcha_response_field" name="recaptcha_response_field"><br>
						{/if}
						<label for="reg_rgt">{$accept_terms_cond}</label><input id="reg_rgt" name="rgt" type="checkbox"><br>
						<input name="submit" value="{$register}" type="submit">
					</form>
					{if $fb_active}<a href="javascript:FBlogin();" class="fb_login"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
				</div>
				<div id="lostbox"><h1>{$lostpassword}</h1>
					<form id="lost" name="lost" action="index.php?page=lostpassword" method="post" onsubmit="return Submit('lost');">
						<label for="universe_lost">{$universe}</label><select name="uni" id="universe_lost">{html_options options=$AvailableUnis selected=$UNI}</select><br>
						<label for="username_lost">{$user}</label><input name="username" id="username_lost" type="text"><br>
						<label for="email_lost">{$email}</label><input name="email" id="email_lost" type="text"><br>
						<input name="submit" value="{$login}" type="submit">
					</form>
				</div>
			</td><td class="contentbox-content-right"></td>
		</tr>
		<tr class="contentbox-footer">
			<td class="contentbox-footer-left"></td><td class="contentbox-footer-center"></td><td class="contentbox-footer-right"></td>
		</tr>
	</table>
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
			<td class="box-content-right"></td>
		</tr>
		<tr class="box-footer">
			<td class="box-footer-left"></td><td class="box-footer-center"></td><td class="box-footer-right"></td>
		</tr>
	</table>
	<table class="box">
		<tr class="box-header">
			<td class="box-header-left"></td><td class="box-header-center"></td><td class="box-header-right"></td>
		</tr>
		<tr class="box-content"><td class="box-content-left"></td><td class="box-content-center">
				{if $mail_active}<a href="#" onclick="return Content('lost');" class="multi"><table class="button button-multi"><tr>
					<td class="button-left"></td><td class="button-center">
						{$lostpassword}
				</td><td class="button-right"></td></tr></table></a>{/if}
				<a href="index.php?page=screens"{if $mail_active} class="multi"{/if}><table class="button{if $mail_active} button-multi{/if}"><tr>
					<td class="button-left"></td><td class="button-center">
						{$screenshots}
					</td><td class="button-right"></td></tr></table></a>
				</td><td class="box-content-right"></td>
		</tr>
		<tr class="box-footer">
			<td class="box-footer-left"></td><td class="box-footer-center"></td><td class="box-footer-right"></td>
		</tr>
	</table>
</section>
{/block}