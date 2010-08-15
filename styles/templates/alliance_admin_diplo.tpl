{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
       <table class="table519">
        <tr>
          <th colspan="3"><a href="javascript:allydiplo('new',0,0);">{$al_diplo_create}</a></th>
        </tr>
        <tr>
          <th colspan="3">{$al_diplo_level.0}</th>
        </tr>
		<tr>
		{foreach key=id item=name from=$DiploInfo.0}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=0" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
		</tr>
        <tr>
          <th colspan="3">{$al_diplo_level.1}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.1}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=1" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.2}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.2}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=2" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.3}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.3}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=3" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.4}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.4}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td>{if $ally_id == $name.2}<a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=4" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a>{else}-{/if}</td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_accept}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.5}
		<tr><td style="width:60%" onmouseout="return nd();" onmouseover="return overlib('{$al_diplo_ground} {$name.3}', CENTER, OFFSETY, -30)";>{$name.0}</td><td>{$al_diplo_level.{$name.2}}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=accept&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_accept_yes_confirm}');"><img src="{$dpath}pic/key.gif" border="0" alt=""></a><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=decline&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_accept_no_confirm}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td colspan="3">{$al_diplo_no_accept}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_accept_send}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.6}
		<tr><td style="width:60%">{$name.0}</td><td>{$al_diplo_level.{$name.2}}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_accept}</td></tr>
		{/foreach}
		<tr>
			<th colspan="3"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></th>
        </tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}