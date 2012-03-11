{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}
<p>
	<table class="table519">
	<tr>
		<th colspan="2">{$LNG.al_diplo_head}</th>
	</tr>
	<tr>
		<td colspan="2">{$LNG.al_diplo_info}</th>
	</tr>
	{foreach $diploList.0 as $diploMode => $diploAlliances}	
	<tr>
		<th colspan="2">{$LNG.al_diplo_level.$diploMode}</th>
	</tr>
		{foreach $diploAlliances as $diploID => $diploName}
		<tr>
			<td style="width:90%">{$diploName}</td>
			<td>
				<a href="game.php?page=alliance&amp;mode=admin&amp;action=diplomacyDelete&amp;id={$diploID}" onclick="return confirm('{$LNG.al_diplo_confirm_delete}');"><img src="styles/images/false.png" alt="" width="16" height="16"></a>
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="2">{$LNG.al_diplo_no_entry}</td>
		</tr>
		{/foreach}
	<tr>
		<td colspan="2">
			<a href="game.php?page=alliance&amp;mode=admin&amp;action=diplomacyCreate&amp;diploMode={$diploMode}" onclick="return Dialog.open(this.href, 650, 300);">{$LNG.al_diplo_create}</a>
		</td>
	</tr>
	{/foreach}
	</table>
</p>
<p>
	<table class="table519">
	<tr>
		<th colspan="2">{$LNG.al_diplo_accept}</th>
	</tr>
	{if array_filter($diploList.1)}
		{foreach $diploList.1 as $diploMode => $diploAlliances}	
		{if !empty($diploAlliances)}
		<tr>
			<th colspan="2">{$LNG.al_diplo_level.$diploMode}</th>
		</tr>
		{foreach $diploAlliances as $diploID => $diploName}
		<tr>
			<td style="width:90%">{$diploName}</td>
			<td>
				<a href="game.php?page=alliance&amp;mode=admin&amp;action=diplomacyAccept&amp;id={$diploID}" onclick="return confirm('{$LNG.al_diplo_accept_yes_confirm}');"><img src="styles/images/true.png" alt="" width="16" height="16"></a>
				<a href="game.php?page=alliance&amp;mode=admin&amp;action=diplomacyDelete&amp;id={$diploID}" onclick="return confirm('{$LNG.al_diplo_accept_no_confirm}');"><img src="styles/images/false.png" alt="" width="16" height="16"></a>
			</td>
		</tr>
		{/foreach}
		{/if}
		{/foreach}
	{else}
	<tr>
		<td colspan="2">{$LNG.al_diplo_no_accept}</td>
	</tr>	
	{/if}
	</table>
</p>
<p>
	<table class="table519">
	<tr>
		<th colspan="2">{$LNG.al_diplo_accept_send}</th>
	</tr>
	{if array_filter($diploList.2)}
		{foreach $diploList.2 as $diploMode => $diploAlliances}	
		{if !empty($diploAlliances)}
		<tr>
			<th colspan="2">{$LNG.al_diplo_level.$diploMode}</th>
		</tr>
		{foreach $diploAlliances as $diploID => $diploName}
		<tr>
			<td style="width:90%">{$diploName}</td>
			<td>
				<a href="game.php?page=alliance&amp;mode=admin&amp;action=diplomacyDelete&amp;id={$diploID}" onclick="return confirm('{$LNG.al_diplo_confirm_delete}');"><img src="styles/images/false.png" alt="" width="16" height="16"></a>
			</td>
		</tr>
		{/foreach}
		{/if}
		{/foreach}
	{else}
	<tr>
		<td colspan="2">{$LNG.al_diplo_no_accept}</td>
	</tr>	
	{/if}
	<tr>
		<th colspan="2"><a href="game.php?page=alliance&amp;mode=admin">{$LNG.al_back}</a></th>
	</tr>
	</table>
</p>
{/block}