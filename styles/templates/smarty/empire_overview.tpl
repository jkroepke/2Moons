{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table border="0" cellpadding="0" cellspacing="1" width="80%" align="center">
        <tbody>
            <tr>
                <td class="c" colspan="{$colspan}">{$iv_imperium_title}</td>
            </tr>
            <tr>
                <th style="width:{100/$colspan}%;">{$iv_planet}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
				<th style="width:{100/$colspan}%;"><a href="game.php?page=overview&amp;cp={$PlanetsInfoRow.InfoList.id}&amp;re=0"><img width="80" height="80" border="0" src="{$dpath}planeten/small/s_{$PlanetsInfoRow.InfoList.image}.jpg" alt="{$PlanetsInfoRow.InfoList.name}"></a></th>
				{/foreach}
            </tr>
            <tr>
				<th>{$iv_name}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.name}</th>
				{/foreach}
            </tr>
            <tr>
				<th>{$iv_coords}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$PlanetsInfoRow.InfoList.galaxy}&amp;system={$PlanetsInfoRow.InfoList.system}">[{$PlanetsInfoRow.InfoList.galaxy}:{$PlanetsInfoRow.InfoList.system}:{$PlanetsInfoRow.InfoList.planet}]</a></th>
				{/foreach}
            </tr>
            <tr>
				<th>{$iv_fields}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.field_current}/{$PlanetsInfoRow.InfoList.field_max}</th>
				{/foreach}
			</tr>
            <tr>
            <td class="c" colspan="{$colspan}" align="left">{$iv_resources}</td>
            </tr>
            <tr>
				<th>{$Metal}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.metal}</th>
				{/foreach}
			</tr>
            <tr>
				<th>{$Crystal}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.crystal}</th>
				{/foreach}
			</tr>
            <tr>
				<th>{$Deuterium}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.deuterium}</th>
				{/foreach}
			</tr>
            <tr>
				<th>{$Energy}</th>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<th>{$PlanetsInfoRow.InfoList.energy_used}/{$PlanetsInfoRow.InfoList.energy_max}</th>
				{/foreach}
            </tr>
			<tr>
                <td class="c" colspan="{$colspan}" align="left">{$iv_buildings}</td>
            </tr>
				{foreach item=Builds from=$build}
					<tr>
					<th>{$tech.$Builds}</th>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<th>{$PlanetsInfoRow.BuildsList.$Builds}</th>
					{/foreach}
					</tr>
				{/foreach}
			<tr>
                <td class="c" colspan="{$colspan}" align="left">{$iv_technology}</td>
			</tr>
				{foreach item=Researchs from=$research}
					<tr>
					<th>{$tech.$Researchs}</th>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<th>{$ResearchList.$Researchs}</th>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
                <td class="c" colspan="{$colspan}" align="left">{$iv_ships}</td>
            </tr>
				{foreach item=Fleets from=$fleet}
					<tr>
					<th>{$tech.$Fleets}</th>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<th>{$PlanetsInfoRow.FleetsList.$Fleets}</th>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
                <td class="c" colspan="{$colspan}" align="left">{$iv_defenses}</td>
            </tr>
				{foreach item=Defenses from=$defense}
					<tr>
					<th>{$tech.$Defenses}</th>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<th>{$PlanetsInfoRow.DefensesList.$Defenses}</th>
					{/foreach}
					</tr>
				{/foreach}
        </tbody>
    </table>
</div>
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}