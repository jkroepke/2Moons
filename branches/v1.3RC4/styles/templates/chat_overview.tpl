{include file="overall_header.tpl"}
{if !$ctype}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
{/if}
<form method="POST" name="chatform" id="chatform" action="javascript:check()">
<input type="hidden" name="chat_type" value="{$ctype}">
<table>
	<tr>
		<th>{$chat_disc}</th>
	</tr>
	<tr>
		<td><div id="shoutbox" style="margin: 5px;vertical-align: text-top;height: {if !$ctype}360px{else}550px;max-width:760px;{/if};overflow:auto;text-align:left;"></div></td>
	</tr>
	<tr>
		<td> 
		{$chat_message}: <input name="msg" type="text" id="msg" style="width:75%" maxlength="255"> 
		<input type="submit" name="send" value="{$chat_send}" id="send">
		</td>
	</tr>
	<tr>
		<td>{$chat_bbcode}: {$chat_fontcolor}: <select name="color" id="chat_color">
			<option style="color:white;" value="white">{$chat_color_white}</option>
			<option style="color:blue;" value="blue">{$chat_color_blue}</option>
			<option style="color:yellow;" value="yellow">{$chat_color_yellow}</option>
			<option style="color:green;" value="green">{$chat_color_green}</option>
			<option style="color:pink;" value="pink">{$chat_color_pink}</option>
			<option style="color:red;" value="red">{$chat_color_red}</option>
			<option style="color:orange;" value="orange">{$chat_color_orange}</option>
		</select>
		&nbsp;&nbsp;
		<input type="button" style="font-weight:bold" name="Bold" value="B" onClick="addBBcode('[b] [/b]')" />
		<input type="button" style="font-style:italic;" name="Italic" value="I" onClick="addBBcode('[i] [/i]')" />
		<input type="button" style="text-decoration:underline;" name="underlined" value="U" onClick="addBBcode('[u] [/u]')" />
		<input type="button" name="url" value="URL" onClick="addBBcode('*URL*')" />
		</td>
	</tr>
	<tr>
		<td> 
			<img src="styles/images/smileys/aggressive.gif" title=":agr:" alt=":agr:" onClick="addSmiley(':agr:')">
			<img src="styles/images/smileys/angel.gif" title=":angel:" alt=":angel:" onClick="addSmiley(':angel:')">
			<img src="styles/images/smileys/bad.gif" title=":bad:" alt=":bad:" onClick="addSmiley(':bad:')">
			<img src="styles/images/smileys/blink.gif" title="o0" alt="o0" onClick="addSmiley(':blink:')">
			<img src="styles/images/smileys/blush.gif" title=":blush:" alt=":blush:" onClick="addSmiley(':blush:')">
			<img src="styles/images/smileys/bomb.gif" title=":bomb:" alt=":blush:" onClick="addSmiley(':bomb:')">
			<img src="styles/images/smileys/clapping.gif" title=":clap:" alt=":clap:" onClick="addSmiley(':clap:')">
			<img src="styles/images/smileys/cool.gif" title=":cool:" alt=":cool:" onClick="addSmiley(':cool:')">
			<img src="styles/images/smileys/cray.gif" title=":c:" alt=":c:" onClick="addSmiley(':c:')">
			<img src="styles/images/smileys/crazy.gif" title=":crz:" alt=":crz:" onClick="addSmiley(':crz:')">
			<img src="styles/images/smileys/diablo.gif" title=":diablo:" alt=":diablo:" onClick="addSmiley(':diablo:')">
			<img src="styles/images/smileys/dirol.gif" title=":cool2:" alt=":cool2:" onClick="addSmiley(':cool2:')">
			<img src="styles/images/smileys/fool.gif" title=":s:" alt=":s:" onClick="addSmiley(':fool:')">
			<br>
			<img src="styles/images/smileys/give_rose.gif" title=":rose:" alt=":rose:" onClick="addSmiley(':rose:')">
			<img src="styles/images/smileys/good.gif" title=":good:" alt=":good:" onClick="addSmiley(':good:')">
			<img src="styles/images/smileys/huh.gif" title=":huh:" alt=":huh:" onClick="addSmiley(':huh:')">
			<img src="styles/images/smileys/lol.gif" title=":D" alt=":D" onClick="addSmiley(':D:')"> 
			<img src="styles/images/smileys/yu.gif" title=":yu" alt=":yu" onClick="addSmiley(':yu')">
			<img src="styles/images/smileys/unknw.gif" title=":unknw:" alt=":unknw:" onClick="addSmiley(':unknw:')">
			<img src="styles/images/smileys/sad.gif" title=":(" alt=":(" onClick="addSmiley(':sad')">
			<img src="styles/images/smileys/smile.gif" title=":)" alt=":)" onClick="addSmiley(':smile')">
			<img src="styles/images/smileys/shok.gif" title=":o" alt=":o" onClick="addSmiley(':shok:')"> 
			<img src="styles/images/smileys/rofl.gif" title=":rofl" alt=":rofl" onClick="addSmiley(':rofl')">
			<img src="styles/images/smileys/blackeye.gif" title=":eye" alt=":eye" onClick="addSmiley(':eye')">
			<img src="styles/images/smileys/tongue.gif" title=":p" alt=":p" onClick="addSmiley(':p')">
			<img src="styles/images/smileys/wink.gif" title=";)" alt=";)" onClick="addSmiley(';)')">                
			<img src="styles/images/smileys/yahoo.gif" title=":yahoo:" alt=":yahoo:" onClick="addSmiley(':yahoo:')">
			<br>
			<img src="styles/images/smileys/mill.gif" title=":tratata:" alt=":tratata:" onClick="addSmiley(':tratata:')">
			<img src="styles/images/smileys/friends.gif" title=":fr:" alt=":fr:" onClick="addSmiley(':fr')">
			<img src="styles/images/smileys/drinks.gif" title=":dr:" alt=":dr:" onClick="addSmiley(':dr')">
			<img src="styles/images/smileys/tease.gif" title=":tease:" alt=":tease:" onClick="addSmiley(':tease:')">
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
var LNG_NoText	= "{$chat_notext}";
var LNG_URL		= "{$chat_request_url}";
var LNG_URLDesc	= "{$chat_request_url_desc}";
</script>
{if !$ctype}
</div>
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}