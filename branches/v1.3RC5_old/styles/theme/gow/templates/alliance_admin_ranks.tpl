{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
	<table style="width:50%"><tr><th colspan="11">{$al_configura_ranks}</th></tr>
	<tr>
		<td>{$al_dlte}</td>
		<td>{$al_rank_name}</td>
		<td><img src="styles/images/r1.png" alt=""></td>
		<td><img src="styles/images/r2.png" alt=""></td>
		<td><img src="styles/images/r3.png" alt=""></td>
		<td><img src="styles/images/r4.png" alt=""></td>
		<td><img src="styles/images/r5.png" alt=""></td>
		<td><img src="styles/images/r6.png" alt=""></td>
		<td><img src="styles/images/r7.png" alt=""></td>
		<td><img src="styles/images/r8.png" alt=""></td>
		<td><img src="styles/images/r9.png" alt=""></td>
	</tr>
	{foreach item=RankInfo from=$AllyRanks}
	<tr>
		<td><input type="hidden" name="id[]" value="{$RankInfo.id}"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights&amp;d={$RankInfo.id}"><img src="{$dpath}pic/abort.gif" alt="{$Delete_range}" border="0"></a></td>
		<td>{$RankInfo.name}</td>
		<td><input type="checkbox" name="u{$RankInfo.id}r0"{if $RankInfo.close} checked="checked"{/if}{if !$close}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r1"{if $RankInfo.kick} checked="checked"{/if}{if !$kick}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r2"{if $RankInfo.seeapply} checked="checked"{/if}{if !$seeapply}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r3"{if $RankInfo.memberlist} checked="checked"{/if}{if !$memberlist}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r4"{if $RankInfo.changeapply} checked="checked"{/if}{if !$changeapply}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r5"{if $RankInfo.admin} checked="checked"{/if}{if !$admin}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r6"{if $RankInfo.memberlist_on} checked="checked"{/if}{if !$memberlist_on}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r7"{if $RankInfo.roundmail} checked="checked"{/if}{if !$roundmail}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r8"{if $RankInfo.righthand} checked="checked"{/if}{if !$righthand}disabled{/if}></td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="11">{$al_no_ranks_defined}</td>
	</tr>
	{/foreach}
	<tr>
		<td colspan="11"><input type="submit" value="{$al_save}"></td>
	</tr>
    </table>
	</form>
    <br>
    <form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
    <table style="width:50%">
        <tr>
          <th colspan="2">{$al_create_new_rank}</th>
        </tr>
        <tr>
          <td>{$al_rank_name}</th>
          <td><input type="text" name="newrangname" size="20" maxlength="30"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" value="{$al_create}"></td>
        </tr>
    </table>
    </form>
    <form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
    <table style="width:50%">
        <tr>
          <th colspan="2">{$al_legend}</th>
        </tr>
        <tr>
          <td><img src="styles/images/r1.png" alt=""></td>
          <td>{$al_legend_disolve_alliance}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r2.png" alt=""></td>
          <td>{$al_legend_kick_users}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r3.png" alt=""></td>
          <td>{$al_legend_see_requests}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r4.png" alt=""></td>
          <td>{$al_legend_see_users_list}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r5.png" alt=""></td>
          <td>{$al_legend_check_requests}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r6.png" alt=""></td>
          <td>{$al_legend_admin_alliance}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r7.png" alt=""></td>
          <td>{$al_legend_see_connected_users}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r8.png" alt=""></td>
          <td>{$al_legend_create_circular}</td>
        </tr>
        <tr>
          <td><img src="styles/images/r9.png" alt=""></td>
          <td>{$al_legend_right_hand}</td>
        </tr>
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></th>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}