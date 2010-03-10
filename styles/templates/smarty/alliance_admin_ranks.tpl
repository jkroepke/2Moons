{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
	<table width="519" align="center"><tr><td class="c" colspan="11">{$al_configura_ranks}</td></tr>
	<tr>
		<th>{$al_dlte}</th>
		<th>{$al_rank_name}</th>
		<th><img src="styles/images/r1.png" alt=""></th>
		<th><img src="styles/images/r2.png" alt=""></th>
		<th><img src="styles/images/r3.png" alt=""></th>
		<th><img src="styles/images/r4.png" alt=""></th>
		<th><img src="styles/images/r5.png" alt=""></th>
		<th><img src="styles/images/r6.png" alt=""></th>
		<th><img src="styles/images/r7.png" alt=""></th>
		<th><img src="styles/images/r8.png" alt=""></th>
		<th><img src="styles/images/r9.png" alt=""></th>
	</tr>
	{foreach item=RankInfo from=$AllyRanks}
	<tr>
		<th><input type="hidden" name="id[]" value="{$RankInfo.id}"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights&amp;d={$RankInfo.id}"><img src="{$dpath}pic/abort.gif" alt="{$Delete_range}" border="0"></a></th>
		<th>{$RankInfo.name}</th>
		<th><input type="checkbox" name="u{$RankInfo.id}r0"{if $RankInfo.close} checked="checked"{/if}{if !$close}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r1"{if $RankInfo.kick} checked="checked"{/if}{if !$kick}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r2"{if $RankInfo.seeapply} checked="checked"{/if}{if !$seeapply}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r3"{if $RankInfo.memberlist} checked="checked"{/if}{if !$memberlist}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r4"{if $RankInfo.changeapply} checked="checked"{/if}{if !$changeapply}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r5"{if $RankInfo.admin} checked="checked"{/if}{if !$admin}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r6"{if $RankInfo.memberlist_on} checked="checked"{/if}{if !$memberlist_on}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r7"{if $RankInfo.roundmail} checked="checked"{/if}{if !$roundmail}disabled{/if}></th>
		<th><input type="checkbox" name="u{$RankInfo.id}r8"{if $RankInfo.righthand} checked="checked"{/if}{if !$righthand}disabled{/if}></th>
	</tr>
	{foreachelse}
	<tr>
		<th colspan="11">{$al_no_ranks_defined}</th>
	</tr>
	{/foreach}
	<tr>
		<th colspan="11"><input type="submit" value="{$al_save}"></th>
	</tr>
    </table>
	</form>
    <br>
    <form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_create_new_rank}</td>
        </tr>
        <tr>
          <th>{$al_rank_name}</th>
          <th><input type="text" name="newrangname" size="20" maxlength="30"></th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" value="{$al_create}"></th>
        </tr>
    </table>
    </form>
    <form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_legend}</td>
        </tr>
        <tr>
          <th><img src="styles/images/r1.png" alt=""></th>
          <th>{$al_legend_disolve_alliance}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r2.png" alt=""></th>
          <th>{$al_legend_kick_users}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r3.png" alt=""></th>
          <th>{$al_legend_see_requests}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r4.png" alt=""></th>
          <th>{$al_legend_see_users_list}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r5.png" alt=""></th>
          <th>{$al_legend_check_requests}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r6.png" alt=""></th>
          <th>{$al_legend_admin_alliance}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r7.png" alt=""></th>
          <th>{$al_legend_see_connected_users}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r8.png" alt=""></th>
          <th>{$al_legend_create_circular}</th>
        </tr>
        <tr>
          <th><img src="styles/images/r9.png" alt=""></th>
          <th>{$al_legend_right_hand}</th>
        </tr>
        <tr>
          <td class="c" colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></td>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}