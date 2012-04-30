{block name="title" prepend}{$LNG.ed_user_head}{/block}
{block name="content"}
<form action="admin.php?page=account" method="post">
<input type="hidden" name="mode" value="detailUser">
<table>
	<tr>
		<th colspan="2">{$LNG.ed_edit} {$infoUserList.username} [ID: {$infoUserList.id}]</th>
	</tr>
	<tr>
		<td style="width:50%"><label>{$LNG.ed_userid}</label></td>
		<td style="width:50%"><span id="userID">{$infoUserList.id}</span></td>
	</tr>
	<tr>
		<td style="width:50%"><label for="username">{$LNG.ed_username}</label></td>
		<td style="width:50%"><span class="editable" id="username">{$infoUserList.username}</span></td>
	</tr>
	<tr>
		<td style="width:50%"><label for="password">{$LNG.ed_password}</label></td>
		<td style="width:50%"><i>{$LNG.ed_change}</i></td>
	</tr>
	<tr>
		<td style="width:50%"><label for="email">{$LNG.ed_email}</label></td>
		<td style="width:50%"><span class="editable" id="email">{$infoUserList.email}</span></td>
	</tr>
	<tr>
		<td style="width:50%"><label for="email2">{$LNG.ed_email2}</label></td>
		<td style="width:50%"><span class="editable" id="email_2">{$infoUserList.email_2}</span></td>
	</tr>
	<tr>
		<td style="width:50%"><label for="email2">{$LNG.ed_rank}</label></td>
		<td style="width:50%"><span class="editable" id="authlevel" data-orginal="{$infoUserList.authlevel}">{$LNG.user_level[$infoUserList.authlevel]}</span></td>
	</tr>
</table>
	<div class="tabs" style="width:750px;margin:0 auto;">
		<ul>
			<li><a href="#planets">{$LNG.ed_planets}</a></li>
			<li><a href="#moons">{$LNG.ed_moons}</a></li>
			<li><a href="#tech-100">{$LNG.tech.100}</a></li>
			<li><a href="#tech-600">{$LNG.tech.600}</a></li>
			<li><a href="#tech-700">{$LNG.tech.700}</a></li>
			<li><a href="#tech-900">{$LNG.tech.900}</a></li>
			<li><a href="#alliance">{$LNG.ed_alliance}</a></li>
			<li><a href="#bans">{$LNG.ed_bans}</a></li>
			<li><a href="#stats">{$LNG.ed_stats}</a></li>
		</ul>
		<div id="planets" style="width:100%;padding: 10px 0 0 0;">
			{if !empty($infoPlanetList.1)}
			<div class="tabs" style="border:0 none;padding:0;">
				<ul>
					{foreach $infoPlanetList.1 as $planetID => $planetRow}
					<li><a href="#planet{$planetID}">[ID: {$planetID}] {$planetRow.name} [{$planetRow.galaxy}:{$planetRow.galaxy}:{$planetRow.planet}]</a></li>
					{/foreach}
				</ul>
				{foreach $infoPlanetList.1 as $planetID => $planetRow}
				<div id="planet{$planetID}" style="width:100%;padding: 10px 0 0 0;">
					<div class="tabs" style="border:0 none;padding:0;">
						<ul>
							<li><a href="#info{$planetID}">{$LNG.ed_planetinfo}</a></li>
							<li><a href="#tech-0">{$LNG.tech.0}</a></li>
							<li><a href="#tech-200">{$LNG.tech.200}</a></li>
							<li><a href="#tech-400">{$LNG.tech.400}</a></li>
						</ul>
						<div id="info{$planetID}">
							<table style="width:100%" class="transparent">
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_planetid}</label></td>
									<td style="width:50%" class="transparent">{$planetID}</td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_name">{$LNG.ed_planetname}</label></td>
									<td style="width:50%" class="transparent"><input type="text" size="20" name="update[planet][{$planetID}][name]" id="planet_{$planetID}_name" value="{$planetRow.name}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_position}</label></td>
									<td style="width:50%" class="transparent">[{$planetRow.galaxy}:{$planetRow.galaxy}:{$planetRow.planet}] <a href="#" onclick="openPositionChanger({$planetID});return false;"><i><u>{$LNG.ed_change}</u></i></a></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_fieldused}</label></td>
									<td style="width:50%" class="transparent">{$planetRow.field.current|number}</td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_fieldmax">{$LNG.ed_fieldmax}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][field_max]" id="planet_{$planetID}_fieldmax" value="{$planetRow.field.max}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_tempmin">{$LNG.ed_tempmin}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][temp_min]" id="planet_{$planetID}_tempmin" value="{$planetRow.temp.min}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_tempmax">{$LNG.ed_tempmax}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][temp_max]" id="planet_{$planetID}_tempmax" value="{$planetRow.temp.max}"></td>
								</tr>
							</table>
						</div>
						<div id="tech-0">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.0 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
						<div id="tech-200">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.200 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" size="15" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
						<div id="tech-400">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.400 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" size="15" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
					</div>
				</div>
				{/foreach}
			</div>
			{/if}
		</div>
		<div id="moons" style="width:100%;padding: 10px 0 0 0;">
			{if !empty($infoPlanetList.3)}
			<div class="tabs" style="border:0 none;padding:0;">
				<ul>
					{foreach $infoPlanetList.3 as $planetID => $planetRow}
					<li><a href="#moon{$planetID}">[ID: {$planetID}] {$planetRow.name} [{$planetRow.galaxy}:{$planetRow.galaxy}:{$planetRow.planet}]</a></li>
					{/foreach}
				</ul>
				{foreach $infoPlanetList.3 as $planetID => $planetRow}
				<div id="moon{$planetID}" style="width:100%;padding: 10px 0 0 0;">
					<div class="tabs" style="border:0 none;padding:0;">
						<ul>
							<li><a href="#info{$planetID}">{$LNG.ed_planetinfo}</a></li>
							<li><a href="#tech-0">{$LNG.tech.0}</a></li>
							<li><a href="#tech-200">{$LNG.tech.200}</a></li>
							<li><a href="#tech-400">{$LNG.tech.400}</a></li>
						</ul>
						<div id="info{$planetID}">
							<table style="width:100%" class="transparent">
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_planetid}</label></td>
									<td style="width:50%" class="transparent">{$planetID}</td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_name">{$LNG.ed_planetname}</label></td>
									<td style="width:50%" class="transparent"><input type="text" size="20" name="update[planet][{$planetID}][name]" id="planet_{$planetID}_name" value="{$planetRow.name}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_position}</label></td>
									<td style="width:50%" class="transparent">[{$planetRow.galaxy}:{$planetRow.galaxy}:{$planetRow.planet}] <a href="#" onclick="openPositionChanger({$planetID});return false;"><i><u>{$LNG.ed_change}</u></i></a></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label>{$LNG.ed_fieldused}</label></td>
									<td style="width:50%" class="transparent">{$planetRow.field.current|number}</td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_fieldmax">{$LNG.ed_fieldmax}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][field_max]" id="planet_{$planetID}_fieldmax" value="{$planetRow.field.max}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_tempmin">{$LNG.ed_tempmin}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][temp_min]" id="planet_{$planetID}_tempmin" value="{$planetRow.temp.min}"></td>
								</tr>
								<tr>
									<td style="width:50%" class="transparent left"><label for="planet_{$planetID}_tempmax">{$LNG.ed_tempmax}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[planet][{$planetID}][temp_max]" id="planet_{$planetID}_tempmax" value="{$planetRow.temp.max}"></td>
								</tr>
							</table>
						</div>
						<div id="tech-0">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.0 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
						<div id="tech-200">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.200 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" size="15" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
						<div id="tech-400">
							<table style="width:100%" class="transparent">
								{foreach $planetRow.400 as $elementID => $elementValue}
								<tr>
									<td style="width:50%" class="transparent left"><label for="tech_{$planetID}_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
									<td style="width:50%" class="transparent"><input type="number" size="15" name="update[tech][{$planetID}][{$elementID}]" id="tech_{$planetID}_{$elementID}" value="{$elementValue}"></td>
								</tr>
								{/foreach}
							</table>
						</div>
					</div>
				</div>
				{/foreach}
			</div>
			{/if}
		</div>
		<div id="tech-100">
			<table style="width:100%" class="transparent">
				{foreach $infoUserList.100 as $elementID => $elementValue}
				<tr>
					<td style="width:50%" class="transparent left"><label for="tech_0_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
					<td style="width:50%" class="transparent"><input type="number" name="update[tech][0][{$elementID}]" id="tech_0_{$elementID}" value="{$elementValue}"></td>
				</tr>
				{/foreach}
			</table>
		</div>
		<div id="tech-600">
			<table style="width:100%" class="transparent">
				{foreach $infoUserList.600 as $elementID => $elementValue}
				<tr>
					<td style="width:50%" class="transparent left"><label for="tech_0_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
					<td style="width:50%" class="transparent"><input type="number" name="update[tech][0][{$elementID}]" id="tech_0_{$elementID}" value="{$elementValue}"></td>
				</tr>
				{/foreach}
			</table>
		</div>
		<div id="tech-700">
			<table style="width:100%" class="transparent">
				{foreach $infoUserList.700 as $elementID => $elementValue}
				<tr>
					<td style="width:50%" class="transparent left"><label for="tech_0_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
					<td style="width:50%" class="transparent"><input type="number" name="update[tech][0][{$elementID}]" id="tech_0_{$elementID}" value="{$elementValue}"></td>
				</tr>
				{/foreach}
			</table>
		</div>
		<div id="tech-900">
			<table style="width:100%" class="transparent">
				{foreach $infoUserList.900 as $elementID => $elementValue}
				<tr>
					<td style="width:50%" class="transparent left"><label for="tech_0_{$elementID}">[ID: {$elementID}] {$LNG.tech.$elementID}</label></td>
					<td style="width:50%" class="transparent"><input type="number" name="update[tech][0][{$elementID}]" id="tech_0_{$elementID}" value="{$elementValue}"></td>
				</tr>
				{/foreach}
			</table>
		</div>
		<div id="alliance">
		
		</div>
		<div id="bans">
		
		</div>
		<div id="stats">
		
		</div>
	</div>
</form>
{/block}
{block name="script" append}
<script src="scripts/game/accountEditor.admin.js"></script>
{/block}