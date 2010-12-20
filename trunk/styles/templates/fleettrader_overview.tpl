{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<form action="" method="POST">
    <table>
        <tr><th>{$ft_head}</th></tr>
        <tr><td>
			<div class="transparent" style="text-align:left;float:left;"><img id="img" src="{$dpath}gebaeude/202.gif" name="{$dpath}gebaeude/"></div>
			<div class="transparent" style="text-align:right;float:right;"><select name="id" id="id" onChange="updateVars()">
			{foreach $trade_allowed_ships as $ID}
			<option value="{$ID}" label="{$tech.$ID}">{$tech.$ID}</option>
			{/foreach}
			</select></div><div style="margin-top:20px;">
			{$ft_count}: <input type="text" id="count" name="count" onkeyup="Total();"><a href="#" onclick="MaxShips();">{$ft_max}</a><br><br>
			{$Metal}: <span id="metal" style="font-weight:800;"></span> &bull; {$Crystal}: <span id="crystal" style="font-weight:800;"></span> &bull; {$Deuterium}: <span id="deuterium" style="font-weight:800;"></span> &bull; {$Darkmatter}: <span id="darkmatter" style="font-weight:800;"></span><br><br>
			{$ft_total}: {$Metal}: <span id="total_metal" style="font-weight:800;"></span> &bull; {$Crystal}: <span id="total_crystal" style="font-weight:800;"></span> &bull; {$Deuterium} <span id="total_deuterium" style="font-weight:800;"></span> &bull; {$Darkmatter}: <span id="total_darkmatter" style="font-weight:800;"></span><br><br>
			<input type="submit" value="Absenden"><br>{$ft_charge}: <span id="charge"></span></div>
		</td></tr>
	</table>
</form>
</div>
<script type="text/javascript">
var CostInfo = {$CostInfos};
var Charge = {$Charge};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}