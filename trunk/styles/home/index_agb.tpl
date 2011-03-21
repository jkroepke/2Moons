{foreach name=MainSector item=Sector key=Name from=$agb}
&sect;{$smarty.foreach.MainSector.iteration} {$Name}<br><br>
{if is_array($Sector)}
{foreach name=SubSector item=SubSector from=$Sector}
{$smarty.foreach.MainSector.iteration}.{$smarty.foreach.SubSector.iteration} {$SubSector}<br><br>
{/foreach}
{else}
{$Sector}<br><br>
{/if}
<br>
{/foreach}