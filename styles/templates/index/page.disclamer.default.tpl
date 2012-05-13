{block name="title" prepend}{$LNG.menu_disclamer}{/block}
{block name="content"}
<table style="width:50%;margin:0 auto">
	<tr>
		<td colspan="2" style="text-align:left;"><p>{$LNG.disclamer_info}</p></td>
	</tr>
		<td style="width:50%;text-align:left;">{$LNG.disclamer_address}&nbsp;:</td><td style="width:50%;text-align:left;">{$disclamerAddress}</td>
	</tr>
	<tr>
		<td style="width:50%;text-align:left;">{$LNG.disclamer_tel}&nbsp;:</td><td style="width:50%;text-align:left;">{$disclamerPhone}</td>
	</tr>
	<tr>
		<td style="width:50%;text-align:left;">{$LNG.disclamer_email}&nbsp;:</td><td style="width:50%;text-align:left;">{$disclamerMail}</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:left;"><p><br></p></td>
	</tr>
	<tr>
		<td colspan="2">{$LNG.disclamer_notice}</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:left;">{$disclamerNotice}</td>
	</tr>
</table>
{/block}