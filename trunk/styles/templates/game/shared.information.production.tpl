{$count = count($productionTable.usedResource)}

<table style="width:100%;">
	<tbody>
		<tr>
			<td colspan="2">
				<table>
				<tr>
					<th>{$LNG.in_level}</th>
					{foreach $productionTable.usedResource as $resourceID}
					<th colspan="2">{$LNG.tech.$resourceID}</th>
					{/foreach}
				</tr>
				<tr>
					<th>&nbsp;</th>
					{foreach $productionTable.usedResource as $resourceID}
					<th>{$LNG.in_prod_p_hour}</th>
					<th>{$LNG.in_difference}</th>
					{/foreach}
				</tr>
				{foreach $productionTable.production as $elementLevel => $productionData}
				<tr>
					<td><span{if $CurrentLevel == $elementLevel} style="color:#ff0000"{/if}>{$elementLevel}</span></td>
					{foreach $productionData as $resourceID => $production}
					{$productionDiff = $production - $productionTable.production.$CurrentLevel.$resourceID}
					<td><span style="color:{if $production > 0}lime{elseif $production < 0}red{else}white{/if}">{$production|number}</span></td>
					<td><span style="color:{if $productionDiff > 0}lime{elseif $productionDiff < 0}red{else}white{/if}">{$productionDiff|number}</span></td>
					{/foreach}
				</tr>
				{/foreach}
				</table>
			</td>
		</tr>
	</tbody>
</table>