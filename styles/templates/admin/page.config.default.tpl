{block name="title" prepend}{$LNG.{"mu_config_$section"}} - {$LNG.{"mu_config_head_$mode"}}{/block}
{block name="content"}
<form action="page=config&amp;mode=update&amp;section=general" method="post">
<table>
	<tr>
		<th>{$LNG.{"se_head_$section"}}</th>
	</tr>
	<tr>
		<td>{$LNG.{"se_info_$section"}}</td>
	</tr>
	<tr>
		<td>
			<table style="width:100%" class="transparent">
			{foreach $configArray as $configKey => $inputSettings}
				<tr>
					<td class="transparent left" style="padding-right:50px;"><label{if $inputSettings.type != 'bool'}for="{$configKey}"{/if}><b>{$LNG.{"se_label_$configKey"}}</b><br><i>{$LNG.{"se_info_$configKey"}}</i></label><br>&nbsp;</td>
					<td class="transparent" style="width:30%">{if $inputSettings.type == 'int'}<input name="{$configKey}" id="{$configKey}" style="width:70px" type="number" min="0" value="{$configValues.$configKey|escape:'html'}">
					{elseif $inputSettings.type == 'string'}<input name="{$configKey}" id="{$configKey}" type="text" value="{$configValues.$configKey|escape:'html'}">
					{elseif $inputSettings.type == 'bool'}<label for="{$configKey}_yes">{$LNG.common_yes}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_yes" type="radio"{if $configValues.$configKey == true} checked{/if}>&nbsp;&nbsp;<label for="{$configKey}_no">{$LNG.common_no}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_no" type="radio"{if $configValues.$configKey == false} checked{/if}>
					{elseif $inputSettings.type == 'array'}{html_options name=$configKey id=$configKey options=$inputSettings.selection selected=$configValues.$configKey}
					{/if}{if isset($inputSettings.unit)}&nbsp;{$LNG[$inputSettings.unit]}{/if}</td>
				</tr>
			{/foreach}
			</table>
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="{$LNG.common_submit}"> <input type="reset" value="{$LNG.common_reset}"></td>
	</tr>
</table>
</form>
{/block}