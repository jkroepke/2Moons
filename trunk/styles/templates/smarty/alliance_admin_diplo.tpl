{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<table width="520" align="center">
        <tr>
          <td class="c" colspan="2"><a href="javascript:allydiplo('new',0,0);">{$al_diplo_create}</a></td>
        </tr>
        <tr>
          <td class="c" colspan="2">{$al_diplo_level.0}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.0}
		<th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=0" onclick="javascript:return confirm('{$MemberInfo.kick}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th>
		{foreachelse}
		<th colspan="2">{$al_diplo_no_entry}</th>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_level.1}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.1}
		<th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=1" onclick="javascript:return confirm('{$MemberInfo.kick}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th>
		{foreachelse}
		<th colspan="2">{$al_diplo_no_entry}</th>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_level.2}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.2}
		<tr><th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=2" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_diplo_no_entry}</th></tr>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_level.3}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.3}
		<tr><th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=3" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_diplo_no_entry}</th></tr>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_level.4}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.4}
		<tr><th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=4" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_diplo_no_entry}</th></tr>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_accept}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.5}
		<tr><th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=accept&amp;id={$id}&amp;level={$name.2}"><img src="{$dpath}pic/key.gif" border="0" alt=""></a><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=decline&amp;id={$id}&amp;level={$name.2}"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_diplo_no_accept}</th></tr>
		{/foreach}
        <tr>
          <td class="c" colspan="2">{$al_diplo_accept_send}</td>
        </tr>
		{foreach key=id item=name from=$DiploInfo.6}
		<tr><th>{$name.0}</th><th><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></th></tr>
		{foreachelse}
		<tr><th colspan="2">{$al_diplo_no_accept}</th></tr>
		{/foreach}
		<tr>
          <td class="c" colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></td>
        </tr>
    </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}