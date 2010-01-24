{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
<table width="50%" align="center">
<tr>
<td class="c" colspan="10">{$mg_overview}
</td>
</tr>
<tr>
{foreach key=MessID item=MessInfo from=$MessageList}
<th style="width:10%;"><a href="javascript:ajax('game.php?page=messages&amp;mode=show&amp;messcat={$MessID}','frame');" style="color:{$MessInfo.color};">{$MessInfo.lang}</a>
{/foreach}
</tr>
<tr>
{foreach key=MessID item=MessInfo from=$MessageList}
<th style="color:{$MessInfo.color};">{$MessInfo.total}</th>
{/foreach}
</tr>
<tr>
<td colspan="20" id="frame" style="margin:0px;padding:0px;">
</td>
</tr>
</table>
<table width="50%" align="center">
<tr>
<td class="c">{$mg_game_operators}</td>
</tr>
{foreach item=OpsInfo from=$OpsList}
<tr>
<th>{$OpsInfo.username}<a href="mailto:{$OpsInfo.email}" title="Schreibe eine Mail an {$OpsInfo.username}"><img src="{$dpath}img/m.gif" alt="Schreibe eine Mail an {$OpsInfo.username}"></a></th>
</tr>
{/foreach}
</table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}