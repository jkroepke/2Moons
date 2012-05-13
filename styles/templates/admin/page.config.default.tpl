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
			<table class="configTable">
			{foreach $configArray as $configKey => $inputSettings}
				<tr class="configRow">
					<td><label{if $inputSettings.type != 'bool'} for="{$configKey}"{/if}><b>{$LNG.{"se_label_$configKey"}}</b>{if !empty($LNG.{"se_info_$configKey"})}<br><i>{$LNG.{"se_info_$configKey"}}</i>{/if}</label></td>
					<td>{if $inputSettings.type == 'int'}<input name="{$configKey}" id="{$configKey}" type="text" pattern="[0-9]+" value="{$configValues.$configKey|escape:'html'}" required>
					{elseif $inputSettings.type == 'string'}<input name="{$configKey}" id="{$configKey}" type="text" value="{$configValues.$configKey|escape:'html'}">
					{elseif $inputSettings.type == 'bool'}<label for="{$configKey}_yes">{$LNG.common_yes}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_yes" type="radio"{if $configValues.$configKey == true} checked{/if}>&nbsp;&nbsp;<label for="{$configKey}_no">{$LNG.common_no}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_no" type="radio"{if $configValues.$configKey == false} checked{/if}>
					{elseif $inputSettings.type == 'array'}{html_options name=$configKey id=$configKey options=$inputSettings.selection selected=$configValues.$configKey}
					{elseif $inputSettings.type == 'textarea'}&nbsp;</td></tr><tr class="configRow"><td class="textarea" colspan="2"><textarea name="{$configKey}" id="{$configKey}">{$configValues.$configKey|escape:'html'}</textarea></td></tr>
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
{block name="script" append}
<script src="./scripts/base/jquery.autosize.js"></script>
<script>$(function() {
	$('textarea').autosize();
});</script>
{/block}