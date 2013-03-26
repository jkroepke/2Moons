{block name="title" prepend}{$LNG.siteTitleIndex}{/block}
{block name="content"}
<section>
	<h1>{$descHeader}</h1>
	<p class="desc">{$descText}</p>
	<p class="desc"><ul id="desc_list">{foreach $LNG.gameInformations as $info}<li>{$info}</li>{/foreach}</ul></p>
</section>
<section>
	<table class="contentbox">
		<tr class="contentbox-header">
			<td class="contentbox-header-left"></td><td class="contentbox-header-center"></td><td class="contentbox-header-right"></td>
		</tr>
		<tr class="contentbox-content">
			<td class="contentbox-content-left"></td><td class="contentbox-content-center">
				<h1>{$LNG.loginHeader}</h1>
				<form id="login" name="login" action="index.php?page=login" data-action="index.php?page=login" method="post">
					<div class="row">
						<label for="universe">{$LNG.universe}</label>
						<select name="uni" id="universe" class="changeAction">{html_options options=$universeSelect selected=$UNI}</select>
					</div>
					<div class="row">
						<label for="username">{$LNG.loginUsername}</label>
						<input name="username" id="username" type="text">
					</div>
					<div class="row">
						<label for="password">{$LNG.loginPassword}</label>
						<input name="password" id="password" type="password">
					</div>
					<div class="row">
						<input type="submit" value="{$LNG.loginButton}">
					</div>
				</form>
				{if $facebookEnable}<a href="#" data-href="index.php?page=externalAuth&method=facebook" class="fb_login"><img src="styles/resource/images/facebook/fb-connect-large.png" alt=""></a>{/if}<!-- http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif -->
				<br><span class="small">{$loginInfo}</span>
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
			<div class="button-important">
				<a href="index.php?page=register">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.buttonRegister}</span>
					<span class="button-right"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="button-box">
		<div class="button-box-inner">
			{if $mailEnable} 
			<div class="button multi">
				<a href="index.php?page=lostPassword">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.buttonLostPassword}</span>
					<span class="button-right"></span>
				</a>
			</div>
			<div class="button multi">
			{else}
			<div class="button">
			{/if}
				<a href="index.php?page=screens">
					<span class="button-left"></span>
					<span class="button-center">{$LNG.buttonScreenshot}</span>
					<span class="button-right"></span>
				</a>
			</div>
		</div>
	</div>
</section>
{/block}
{block name="script" append}
<script>{if $code}alert({$code|json});{/if}</script>
{/block}