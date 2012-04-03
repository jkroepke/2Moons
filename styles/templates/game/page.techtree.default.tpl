{block name="title" prepend}{$LNG.lm_technology}{/block}
{block name="content"}
<table style="min-width:569px;width:569px;">
{foreach $TechTreeList as $classID => $classElements}
	<tr>
		<th colspan="2">{$LNG.tech.$classID}</th>
		<th>{$LNG.tt_requirements}</th>
	</tr>
	{foreach $classElements as $elementID => $requireList}
	<tr>
		<td><a href="#" onclick="return Dialog.info({$elementID})"><img src="{$dpath}gebaeude/{$elementID}.{if $elementID >=600 && $elementID <= 699}jpg{else}gif{/if}" width="50" height="50"></a></td>
		<td><a href="#" onclick="return Dialog.info({$elementID})">{$LNG.tech.$elementID}</a></td>
		<td>
		{foreach $requireList as $requireID => $NeedLevel}
			<a href="#" onclick="return Dialog.info({$elementID})"><span style="color:{if $NeedLevel.own < $NeedLevel.count}red{else}lime{/if};">{$LNG.tech.$requireID} ({$LNG.tt_lvl} {min($NeedLevel.count, $NeedLevel.own)}/{$NeedLevel.count})</span></a>{if !$NeedLevel@last}<br>{/if}
		{foreachelse}
		&nbsp;
		{/foreach}
		</td>
	</tr>
{/foreach}
{/foreach}
</table>
{/block}