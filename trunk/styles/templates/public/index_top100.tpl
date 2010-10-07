{if !$getajax}{include file="public/index_header.tpl"}{/if}
<table id='registration' class='box-complex box box-full box1'><tr><td><table class='box1_box-header box-header'><tr><td class='box1_box-header-left box-header-left'>&nbsp;</td><td class='box1_box-header-center box-header-center'>&nbsp;</td><td class='box1_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box1_box-content box-content'><tr><td class='box1_box-content-left box-content-left'>&nbsp;</td><td class='box1_box-content-center box-content-center'><div class='box1_content'><center>
                          <div id='logo_v2'></div>
                          <br />
                          <br /></center><table id='registration-inside' class='box-complex box box-compact box5' style="width:80%"><tr><td><table class='box5_box-header box-header'><tr><td class='box5_box-header-left box-header-left'>&nbsp;</td><td class='box5_box-header-center box-header-center'><div class='box5_box-title-wrapper box-title-wrapper'><div class='box5_box-title-container box-title-container'><table class='box5_box-title box-title'><tr><td class='box5_box-title-left box-title-left'>&nbsp;</td>
<td class='box5_box-title-center box-title-center'>{$tkb_top}</td><td class='box5_box-title-right box-title-right'>&nbsp;</td></tr></table></div></div></td><td class='box5_box-header-right box-header-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box5_box-content box-content'><tr><td class='box5_box-content-left box-content-left'>&nbsp;</td><td class='box5_box-content-center box-content-center'><div class='box5_content'><div class='box5_box-title-pad box-title-pad'>&nbsp;</div><table class='layout' cellpadding='5' width='80%'><tr><th colspan='2' width='80%'>
	<br>
	<table style="width:100%;text-align:center;padding-top:3px;">
	<tbody>
	<tr>
		<td colspan="4">
			<span style="color:#E75B12">{$tkb_gratz}</span>
		</td>
	</tr><tr>
		<td><span style="color:lime">{$tkb_platz}</span></td>
		<td><span style="color:lime">{$tkb_owners}</span></td>
		<td><span style="color:lime">{$tkb_datum}</span></td>
		<td><span style="color:lime">{$tkb_units}</span></td>
	</tr>
	{foreach item=RowInfo key=RowNR from=$TopKBList}
	<tr>
		<td>{$RowNR + 1}</td>
		<td>
		{if $RowInfo.result == "a"}
		<span style="color:#00FF00">{$RowInfo.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#FF0000">{$RowInfo.defender}</span>
		{elseif $RowInfo.result == "r"}
		<span style="color:#FF0000">{$RowInfo.attacker}</span><span style="color:#FFFFFF"><b> VS </b></span><span style="color:#00FF00">{$RowInfo.defender}</span>
		{else}
		{$RowInfo.attacker}<b> VS </b>{$RowInfo.defender}
		{/if}
		</td>
		<td>{$RowInfo.time}</td>
		<td>{$RowInfo.units}</td>
	</tr>
	{/foreach}
	<tr>
	<td colspan="4">{$tkb_legende}<span style="color:#00FF00">{$tkb_gewinner}</span><span style="color:#FF0000">{$tkb_verlierer}</span></td>
	</tr>
	</tbody>
	</table>
</th></tr>
</table></div></td><td class='box5_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box5_box-footer box-footer'><tr><td class='box5_box-footer-left box-footer-left'>&nbsp;</td><td class='box5_box-footer-center box-footer-center'>&nbsp;</td><td class='box5_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table><div class='box1_box-status-pad box-status-pad'>&nbsp;</div></div></td><td class='box1_box-content-right box-content-right'>&nbsp;</td></tr></table></td></tr><tr><td><table class='box1_box-footer box-footer'><tr><td class='box1_box-footer-left box-footer-left'>&nbsp;</td><td class='box1_box-footer-center box-footer-center'><div class='box1_box-status-wrapper box-status-wrapper'><div class='box1_box-status-container box-status-container'><table class='box1_box-status box-status'><tr><td class='box1_box-status-left box-status-left'>&nbsp;</td><td class='box1_box-status-center box-status-center'></td>
<td class='box1_box-status-right box-status-right'>&nbsp;</td></tr></table></div></div></td><td class='box1_box-footer-right box-footer-right'>&nbsp;</td></tr></table>
<table class='box1_box-footer box-footer'><tr><td class='box1_box-footer-left box-footer-left'>&nbsp;</td><td class='box1_box-footer-center box-footer-center'><div class='box1_box-status-wrapper box-status-wrapper'><div class='box1_box-status-container box-status-container'><table class='box1_box-status box-status'><tr><td class='box1_box-status-left box-status-left'>&nbsp;</td>
<td class='box1_box-status-center box-status-center'>&nbsp;</td>
<td class='box1_box-status-right box-status-right'>&nbsp;</td></tr></table></div></div></td><td class='box1_box-footer-right box-footer-right'>&nbsp;</td></tr></table></td></tr></table>
{if !$getajax}{include file="public/index_footer.tpl"}{/if}