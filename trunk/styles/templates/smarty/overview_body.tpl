{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="519" align="center">
        <tr>
        	<td class="c" colspan="4"><a onclick="$('.containerPlus').mb_open();" title="{$ov_planetmenu}" style="cursor:pointer;">{$ov_planet} "<span class="planetname">{$planetname}</span>"</a> ({$username})</td>
        </tr>
        {if $messages}
		<tr><th colspan="4"><a href="?page=messages">{$messages}</a></th></tr>
		{/if}
        <tr>
        	<th>{$ov_server_time}</th>
        	<th colspan="4" id="servertime"></th>
        </tr>
		{if $is_news}
		<tr><th>{$ov_news}</th><th colspan="4">{$news}</th></tr>
		{/if}
        <tr>
        	<th>{$ov_admins_online}</th>
        	<th colspan="4">
			{foreach name=OnlineAdmins key=id item=Name from=$AdminsOnline}{if !$smarty.foreach.OnlineAdmins.first}&nbsp;&bull;&nbsp;{/if}<a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$id}','');">{$Name}</a>{foreachelse}{$ov_no_admins_online}{/foreach}</th>
        </tr>		
		{if $Teamspeak}
		<tr>
		<th>{$ov_teamspeak}</th><th colspan="3">{$Teamspeak}</th>
		</tr>
		{/if}
        <tr>
        	<td colspan="4" class="c">{$ov_events}</td>
        </tr>
        {foreach item=FleetInfoRow from=$fleets}
		<tr class="{$FleetInfoRow.fleet_status}">
			<th>
			{$FleetInfoRow.fleet_javai}
				<div id="bxx{$FleetInfoRow.fleet_order}" class="z">-</div>
			</th><th colspan="3">
				{$FleetInfoRow.fleet_descr}
			{$FleetInfoRow.fleet_javas}
			</th>
		</tr>
		{/foreach}
        <tr>
        	<th>{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}"><img src="{$dpath}planeten/mond.jpg" height="50" width="50" alt="{$Moon.name} ({$fcm_moon})"></a><br>{$Moon.name} ({$fcm_moon}){else}&nbsp;{/if}</th>
        	<th colspan="2"><img src="{$dpath}planeten/{$planetimage}.jpg" height="200" width="200" alt="{$planetname}"><br>{$build}</th>
        	<th>
            {if $AllPlanets}
			<table class="s" border="0" align="center">
			{foreach name=PlanetList item=PlanetRow from=$AllPlanets}
			{if $smarty.foreach.PlanetList.iteration is odd}<tr style="height:20px;">{/if}			
			<th class="s">{$PlanetRow.name}<br><a href="game.php?page=overview&amp;cp={$PlanetRow.id}&amp;re=0" title="{$PlanetRow.name}"><img src="{$dpath}planeten/small/s_{$PlanetRow.image}.jpg" alt="{$PlanetRow.name}"></a><br><center>{$PlanetRow.build}</center></th>
			{if $smarty.foreach.PlanetList.last && $smarty.foreach.PlanetList.total is odd && $smarty.foreach.PlanetList.total != 1}<th class="s">&nbsp;</th>{/if}
			{if $smarty.foreach.PlanetList.iteration is even}</tr>{/if}
			{/foreach}
			</table>
			{else}&nbsp;{/if}
            </th>
        </tr>
        <tr>
            <th>{$ov_diameter}</th>
            <th colspan="3">{$planet_diameter} {$ov_distance_unit} (<a title="{$ov_developed_fields}">{$planet_field_current}</a> / <a title="{$ov_max_developed_fields}">{$planet_field_max}</a> {$ov_fields})</th>
        </tr>
        <tr>
            <th>{$ov_temperature}</th>
            <th colspan="3">{$ov_aprox} {$planet_temp_min}{$ov_temp_unit} {$ov_to} {$planet_temp_max}{$ov_temp_unit}</th>
        </tr>
        <tr>
            <th>{$ov_position}</th>
            <th colspan="3"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></th>
        </tr>
        <tr>
            <th>{$ov_points}</th>
            <th colspan="3">{$user_rank}</th>
        </tr>
		{if !CheckModule(37)}
		<tr>
			<td class="c" colspan="4">{$ov_userbanner}</td>
		</tr>
		<tr>
			<th colspan="4"><img src="userpic.php?id={$userid}" alt="" height="80" width="450"><br><br><table><tr><td>HTML:</td><td><input type="text" value='<a href="http://{$smarty.server.SERVER_NAME}{$path}"><img src="http://{$smarty.server.SERVER_NAME}{$path}userpic.php?id={$userid}"></a>' readonly style="width:450px;"></td></tr><tr><td>BBCode:</td><td><input type="text" value="[url='http://{$smarty.server.SERVER_NAME}{$path}'][img]http://{$smarty.server.SERVER_NAME}{$path}userpic.php?id={$userid}[/img][/url]" readonly style="width:450px;"></td></tr></table></th>
		</tr>
		{/if}
   </table>
	<script type="text/javascript">
	Servertime(ctimestamp);
	$(function(){
      $(".containerPlus").buildContainers({
        containment:"document",
        elementsPath:"styles/css/mbContainer/",
        onClose:function(o){},
        effectDuration:500,
		slideTimer:300,
        autoscroll:true,
      });
	});

	function checkrename()
	{
		if($('#newname').val() == '') {
			return false;
		} else {
			$.post('game.php?page=overview&mode=renameplanet&ajax=1', $('#rename').serialize(), function(response){
				if(response == '') {
					$('.planetname').text($('#newname').val());
					$('#demoContainer').mb_close();
				} else {
					alert(response);
				}
			});
			return false;
		}
	}

	function checkcancel()
	{
		if($('#password').val() == '') {
			return false;
		} else {
			$.post('game.php?page=overview&mode=deleteplanet&ajax=1', $('#rename').serialize(), function(response){
				if(response == '') {
					alert('{$ov_planet_abandoned}');
					document.location.href = 'game.php?page=overview';
				} else {
					alert(response);
				}
			});
			return false;
		}
	}
	
	function cancel()
	{
		$('#submit-rename').hide();
		$('#submit-cancel').show();
		$('#label').text('{$ov_password}');
		$('#newname').hide();
		$('#password').show();
	}
</script>
</div>
  <div id="demoContainer" class="containerPlus draggable resizable { buttons:'c', skin:'black', width:'580', height:'200',dock:'dock',closed:'true'}" style="position:absolute;top:250px;left:400px; height:50%">
    <div class="no"><div class="ne"><div class="n">{$ov_planet_rename_action}</div></div>
      <div class="o"><div class="e"><div class="c">
        <div class="mbcontainercontent">
          	<form action="" method="POST" id="rename">
			<table width="519" align="center">
			<tr>
				<td class="c" colspan=3>{$ov_your_planet}</td>
			</tr><tr>
				<th>{$ov_coords}</th>
				<th>{$ov_planet_name}</th>
				<th>{$ov_actions}</th>
			</tr><tr>
				<th>{$galaxy}:{$system}:{$planet}</th>
				<th>{$planetname}</th>
				<th><input type="button" value="{$ov_abandon_planet}" onclick="cancel();"></th>
			</tr><tr>
				<th id="label">{$ov_planet_rename}</th>
				<th><input type="text" name="newname" id="newname" size="25" maxlength="20"><input type="password" name="password" id="password" size="25" maxlength="20" style="display:none;"></th>
				<th><input type="button" onclick="checkrename();" value="{$ov_planet_rename_action}" id="submit-rename"><input type="button" onclick="checkcancel();" value="{$ov_delete_planet}" id="submit-cancel" style="display:none;"></th>
			</tr>
			</table>
			</form>
        </div>
      </div></div></div>
      <div >
        <div class="so"><div class="se"><div class="s"> </div></div></div>
      </div>
    </div>
  </div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}