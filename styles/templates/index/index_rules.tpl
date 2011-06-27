{extends file="index.tpl"}
{block name="title" prepend}{$menu_rules}{/block}
{block name="content"}
<span style="color:#FFFFFF"><br>
{foreach name=Rules key=Head item=Rule from=$rules}
<b>{$smarty.foreach.Rules.iteration}. {$Head}</b>
<br><br>
{$Rule}
<br><br><br>
{/foreach}
{$rules_info1}
<h2>{$rules_info2}</h2>
{/block}