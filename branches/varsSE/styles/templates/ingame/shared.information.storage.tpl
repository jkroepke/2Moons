{$count = $productionTable.usedResource}

<table style="width:100%;">
	<tbody>
		<tr>
			<td colspan="2">
				<table>
				<tr>
					<th>{$LNG.in_level}</th>
				{if $count > 1}
					{foreach $productionTable.usedResource as $resourceID}
					<th colspan="2">{$LNG.tech.$resourceID}</th>
					{/foreach}
				</tr>
				<tr>
					<th>&nbsp;</th>
				{/if}
					{foreach $productionTable.usedResource as $resourceID}
					<th>{$LNG.in_storage}</th>
					<th>{$LNG.in_difference}</th>
					{/foreach}
				</tr>
				{foreach $productionTable.storage as $elementLevel => $productionData}
				<tr>
					<td><span{if $CurrentLevel == $elementLevel} style="color:#ff0000"{/if}>{$elementLevel}</span></td>
					{foreach $productionData as $resourceID => $storage}
					{$storageDiff = $storage - $productionTable.storage.$CurrentLevel.$resourceID}
					<td><span style="color:{if $storage > 0}lime{elseif $storage < 0}red{else}white{/if}">{$storage|number}</span></td>
					<td><span style="color:{if $storageDiff > 0}lime{elseif $storageDiff < 0}red{else}white{/if}">{$storageDiff|number}</span></td>
					{/foreach}
				</tr>
				{/foreach}
				</table>
			</td>
		</tr>
	</tbody>
</table>