{include file="overall_header.tpl"}
{include file="left_menu.tpl"}
{include file="overall_topnav.tpl"}
<div id="content">
<table>
<tr>
<th colspan="11">{lang}mg_overview{/lang}</th>
</tr>
<tr>
{foreach name=MessageList key=MessID item=MessInfo from=$MessageList}
<td style="width:{100 / $smarty.foreach.MessageList.total}%;"><a href="#" onclick="Message.getMessages({$MessID});return false;" style="color:{$MessInfo.color};">{lang}mg_type.{$MessID}{/lang}</a></td>
{/foreach}
</tr>
<tr id="messcount">
{foreach key=MessID item=MessInfo from=$MessageList}
<td style="color:{$MessInfo.color};"><span id="unread_{$MessID}">{$MessInfo.unread}</span>/<span id="total_{$MessID}">{$MessInfo.total}</span></td>
{/foreach}
</tr>
</table>
<table>
<tr>
<th colspan="11">{lang}mg_game_operators{/lang}</th>
</tr>
{foreach item=OpsInfo from=$OpsList}
<tr>
<td colspan="11">{$OpsInfo.username}<a href="mailto:{$OpsInfo.email}" title="Schreibe eine Mail an {$OpsInfo.username}"><img src="{$dpath}img/m.gif" alt="Schreibe eine Mail an {$OpsInfo.username}"></a></td>
</tr>
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}