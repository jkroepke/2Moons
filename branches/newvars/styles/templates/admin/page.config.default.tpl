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
					<td class="descRow"><label{if $inputSettings.type != 'bool'} for="{$configKey}"{/if}><b>{$LNG.{"se_label_$configKey"}}</b>{if strlen($LNG.{"se_info_$configKey"}) != 0}<br><i>{$LNG.{"se_info_$configKey"}}</i>{/if}</label></td>
					<td class="inputRow">{if $inputSettings.type == 'int'}<input name="{$configKey}" id="{$configKey}" type="text" pattern="[0-9]+" value="{$configValues.$configKey|escape:'html'}" required>
					{elseif $inputSettings.type == 'float'}<input name="{$configKey}" id="{$configKey}" type="text" pattern="[0-9]+[\.|,]?[0-9]*" value="{$configValues.$configKey|escape:'html'}" required>
					{elseif $inputSettings.type == 'string'}<input name="{$configKey}" id="{$configKey}" type="text" value="{$configValues.$configKey|escape:'html'}">
					{elseif $inputSettings.type == 'bool'}<label for="{$configKey}_yes">{$LNG.common_yes}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_yes" type="radio"{if $configValues.$configKey == true} checked{/if}>&nbsp;&nbsp;<label for="{$configKey}_no">{$LNG.common_no}</label>&nbsp;<input name="{$configKey}" id="{$configKey}_no" type="radio"{if $configValues.$configKey == false} checked{/if}>
					{elseif $inputSettings.type == 'array'}{html_options name=$configKey id=$configKey options=$inputSettings.selection selected=$configValues.$configKey}
					{elseif $inputSettings.type == 'multi'}{html_options multiple="multiple" size="7" name=$configKey id=$configKey options=$inputSettings.selection selected=$configValues.$configKey}
					{elseif $inputSettings.type == 'textarea'}&nbsp;</td></tr><tr class="configRow"><td class="textarea" colspan="2"><textarea name="{$configKey}" id="{$configKey}">{$configValues.$configKey|escape:'html'}</textarea></td></tr>
					{/if}</td>
					{if $inputSettings.type != 'textarea'}<td class="unitRow">{if isset($inputSettings.unit)}{if substr($inputSettings.unit, 0, 5) == 'tech.' && isset($LNG[substr($inputSettings.unit, 0, 4)][substr($inputSettings.unit, 5)])}{$LNG[substr($inputSettings.unit, 0, 4)][substr($inputSettings.unit, 5)]}{else}{$LNG[$inputSettings.unit]}{/if}{else}&nbsp;{/if}</td>{/if}
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