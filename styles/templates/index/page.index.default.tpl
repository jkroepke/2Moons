{block name="title" prepend}{$LNG.menu_index}{/block}
{block name="content"}
<section>
	<h1>{$LNG.welcome_to} {$servername}</h1>
	<p class="desc">{$LNG.server_description|replace:'%s':$servername}</p>
	<p class="desc"><ul id="desc_list">{foreach $LNG.server_infos as $item}<li>{$item}</li>{/foreach}</ul>
</section>
<section>
	<table class="contentbox">
		<tr class="contentbox-header">
			<td class="contentbox-header-left"></td><td class="contentbox-header-center"></td><td class="contentbox-header-right"></td>
		</tr>
		<tr class="contentbox-content">
			<td class="contentbox-content-left"></td><td class="contentbox-content-center">
				<div id="loginbox"><h1>{$LNG.login}</h1>
					<form id="login" name="login" action="index.php?page=login" method="post">
						<div class="row">
							<label for="universe">{$LNG.universe}</label>
							<select name="uni" id="universe">{html_options options=$AvailableUnis selected=$UNI}</select>
						</div>
						<div class="row">
							<label for="username">{$LNG.user}</label>
							<input name="username" id="username" type="text">
						</div>
						<div class="row">
							<label for="password">{$LNG.pass}</label>
							<input name="password" id="password" type="password">
						</div>
						<div class="row">
							<input type="submit" value="{$LNG.login}">
						</div>
					</form>
					{if $fb_active}<a href="javascript:FBlogin();" class="fb_login"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
					<br><span class="small">{$LNG.login_info}</span>
				</div>
				<div id="regbox"><h1>{$LNG.register}</h1>
					<form id="reg" name="reg" action="index.php?page=register&amp;mode=send" method="post" onsubmit="return false;">
						{if $fb_active}<input type="hidden" name="fb_id" id="fb_id">{/if}
						{if $ref_id}<input type="hidden" name="ref_id" id="ref_id" value="{$ref_id}"><input type="hidden" name="uni" id="ref_uni" value="{$ref_uni}">{else}
						<div class="row">
							<label for="reg_universe">{$LNG.universe}</label>
							<select name="uni" id="reg_universe">{html_options options=$AvailableUnis selected=$UNI}</select>
						</div>{/if}
						<div class="row">							
							<label for="reg_username">{$LNG.user}</label>
							<input name="username" id="reg_username" type="text">
						</div>
						<div class="row">							
							<label for="reg_password">{$LNG.pass}</label>					
							<input name="password" id="reg_password" type="password">
						</div>
						<div class="row">							
							<label for="reg_password_2">{$LNG.pass2_reg}</label>
							<input name="password_2" id="reg_password_2" type="password">
						</div>
						<div class="row">							
							<label for="reg_email">{$LNG.email_reg}</label>
							<input name="email" id="reg_email" type="email">
						</div>
						<div class="row">
							<label for="reg_email_2">{$LNG.email2_reg}</label>
							<input name="email_2" id="reg_email_2" type="email">
						</div>
						<div class="row">
							<label for="reg_lang">{$LNG.lang_reg}</label>
							<select name="lang" id="reg_lang" class="lang"></select>
						</div>
							{if $game_captcha}
						<div class="row">
							<div id="recaptcha_image"></div>
							<label for="recaptcha_response_field">{$captcha_reg}</label>
							<input type="text" id="recaptcha_response_field" name="recaptcha_response_field">
						</div>
						{/if}
						<div class="row">
							<label for="reg_rgt">{$LNG.accept_terms_and_conditions}</label>
							<input id="reg_rgt" name="rgt" type="checkbox" value="1">
						</div>
						<div class="row">
							<input name="submit" value="{$LNG.register}" type="button" onclick="Submit('reg');">
						</div>
					</form>
					{if $fb_active}<a href="javascript:FBlogin();" class="fb_login"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
				</div>
				<div id="lostbox"><h1>{$LNG.lostpassword}</h1>
					<form id="lost" name="lost" action="index.php?page=lostPassword" method="post" onsubmit="return false;">
						<div class="row">
							<label for="universe_lost">{$LNG.universe}</label>
							<select name="uni" id="universe_lost">{html_options options=$AvailableUnis selected=$UNI}</select>
						</div>
						<div class="row">
							<label for="username_lost">{$LNG.user}</label>
							<input name="username" id="username_lost" type="text">
						</div>
						<div class="row">
							<label for="email_lost">{$LNG.email_reg}</label>
							<input name="email" id="email_lost" type="text">
						</div>
						<div class="row">
							<input name="submit" value="{$LNG.lost_pass_send}" type="button" onclick="Submit('lost');">
						</div>
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
	<div class="button-box">
		<div class="button-box-inner">
			<div class="button-important multi">
				<a href="#" onclick="return Content('login');">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.login}</span>
					<span class="button-right"></span>
				</a>
			</div>
			<div class="button-important multi">
				<a href="#" onclick="return Content('register');">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.register_now}</span>
					<span class="button-right"></span>
				</a>
			</div>
		</div>
	</div>
	
	<div class="button-box">
		<div class="button-box-inner">
			{if $mail_active} 
			<div class="button multi">
				<a href="#" onclick="return Content('lost');">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.lostpassword}</span>
					<span class="button-right"></span>
				</a>
			</div>
			<div class="button multi">
			{else}
			<div class="button">
			{/if}
				<a href="index.php?page=screens">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.screenshots}</span>
					<span class="button-right"></span>
				</a>
			</div>
		</div>
	</div>
</section>
{/block}