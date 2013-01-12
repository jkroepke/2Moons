{block name="title" prepend}{$LNG.lm_battlesim}{/block}
{block name="content"}
<form id="form" name="battlesim">
	<input type="hidden" name="slots" id="slots" value="{$Slots + 1}">
	<table style="width:80%">
		<tr>
			<th>{$LNG.lm_battlesim}</th>
		</tr>
		<tr>
			<td>{$LNG.bs_steal} {$LNG.tech.901}: <input type="text" size="10" value="{if isset($battleinput.0.1.1)}{$battleinput.0.1.1}{else}0{/if}" name="battleinput[0][1][1]"> {$LNG.tech.902}: <input type="text" size="10" value="{if isset($battleinput.0.1.2)}{$battleinput.0.1.2}{else}0{/if}" name="battleinput[0][1][2]"> {$LNG.tech.903}: <input type="text" size="10" value="{if isset($battleinput.0.1.3)}{$battleinput.0.1.3}{else}0{/if}" name="battleinput[0][1][3]"></td>
		</tr>
		<tr>
			<td class="left"><input type="button" onClick="return add();" value="{$LNG.bs_add_acs_slot}"></td>
		</tr>
		<tr>
			<td class="transparent" style="padding:0;">
				<div id="tabs">
					<ul>
						{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">{$LNG.bs_acs_slot} {$smarty.section.tab.index + 1}</a></li>{/section}
					</ul>
					{section name=content start=0 loop=$Slots}
					<div id="tabs-{$smarty.section.content.index}">
						<table>
							<tr>
								<th>{$LNG.bs_techno}</th>
								<th>{$LNG.bs_atter}</th>
								<th>{$LNG.bs_deffer}</th>
							</tr>
							<tr>
								<td></td>
								<td><button class="reset">{$LNG.bs_reset}</button></td>
								<td><button class="reset">{$LNG.bs_reset}</button></td>
							</tr>
							<tr>
								<td>{$LNG.tech.109}:</td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.109)}{$battleinput.{$smarty.section.content.index}.0.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][109]"></td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.109)}{$battleinput.{$smarty.section.content.index}.1.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][109]"></td>
							</tr>
							<tr>
								<td>{$LNG.tech.110}:</td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.110)}{$battleinput.{$smarty.section.content.index}.0.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][110]"></td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.110)}{$battleinput.{$smarty.section.content.index}.1.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][110]"></td>
							</tr>
							<tr>
								<td>{$LNG.tech.111}:</td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.111)}{$battleinput.{$smarty.section.content.index}.0.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][111]"></td>
								<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.111)}{$battleinput.{$smarty.section.content.index}.1.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][111]"></td>
							</tr>
						</table>
						<br>
						<table>
							<tr>
								<td class="transparent">
									<table>
										<tr>
											<th>{$LNG.bs_names}</th>
											<th>{$LNG.bs_atter}</th>
											<th>{$LNG.bs_deffer}</th>
										</tr>
										<tr>
											<td></td>
											<td><button class="reset">{$LNG.bs_reset}</button></td>
											<td><button class="reset">{$LNG.bs_reset}</button></td>
										</tr>
										{foreach $fleetList as $id}
										<tr>
											<td>{$LNG.tech.$id}:</td>
											<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.0.$id)}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></td>
											<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.$id)}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
										</tr>
										{/foreach}
									</table>
								</td>
								{if $smarty.section.content.index == 0}
									<td style="width:50%" class="transparent">
										<table>
											<tr>
												<th>{$LNG.bs_names}</td>
												<th>{$LNG.bs_atter}</th>
												<th>{$LNG.bs_deffer}</th>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td><button class="reset">{$LNG.bs_reset}</button></td>
											</tr>
											{foreach $defensiveList as $id}
											<tr>
												<td>{$LNG.tech.$id}:</td>
												<td>-</td>
												<td><input type="text" size="10" value="{if isset($battleinput.{$smarty.section.content.index}.1.$id)}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
											</tr>
										{/foreach}
										</table>
									</td>
								{/if}
							</tr>
						</table>
					</div>
					{/section}
				</div>
			</td>
		</tr>
		<tr id="submit">
			<td><input type="button" onClick="return check();" value="{$LNG.bs_send}">&nbsp;<input type="reset" value="{$LNG.bs_cancel}"></td>
		</tr>
		<tr id="wait" style="display:none;">
			<td style="height:20px">{$LNG.bs_wait}</td>
		</tr>
	</table>
</form>
{/block}