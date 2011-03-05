{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table style="width:50%">
        <tr>
          <th>{$al_manage_alliance}</th>
        </tr>
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights">{$al_manage_ranks}</a></td>
        </tr>
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members">{$al_manage_members}</a></td>
        </tr>
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=tag">{$al_manage_change_tag}</a></td>
        </tr>
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=name">{$al_manage_change_name}</a></td>
        </tr>
		{if $righthand}
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=diplo">{$al_manage_diplo}</a></td>
        </tr>
		{/if}
    </table>
    <form action="" method="POST">
    <input type="hidden" name="t" value="{$t}">
    <table style="width:50%">
        <tr>
          <th colspan="3">{$al_texts}</th>
        </tr>
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=1">{$al_outside_text}</a></td>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=2">{$al_inside_text}</a></td>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=3">{$al_request_text}</a></td>
        </tr>
        <tr>
          <th colspan="3">{$al_message} (<span id="cntChars">0</span> / 5000 {$al_characters})</th>
        </tr>
        <tr>
          <td colspan="3"><div class="btn bold" title="bold"></div><div class="btn italic"></div><div class="btn underline"></div><div class="btn link"></div><div class="btn quote"></div>
		<div class="btn code"></div><div class="btn image"></div><div class="btn usize"></div><div class="btn dsize"></div>
		<div class="btn blist"></div><div class="btn litem"></div><div class="btn back"></div><div class="btn forward"></div><br>
		<textarea name="text" id="text" cols="70" rows="15" onkeyup="$('#cntChars').text($('#text').val().length);" class="bbcode">{$text}</textarea>
        </td>
        </tr>
		<tr><td colspan="3">
		<div class="preview"></div>
		</td>
		</tr>
        <tr>
          <td colspan="3">
          <input type="reset" value="{$al_circular_reset}"> 
          <input type="submit" value="{$al_save}">
          </td>
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table style="width:50%">
        <tr>
          <th colspan="2">{$al_manage_options}</th>
        </tr>
        <tr>
          <td>{$al_web_site}</td>
          <td><input type="text" name="web" value="{$ally_web}" size="70"></td>
        </tr>
        <tr>
          <td>{$al_manage_image}</td>
          <td><input type="text" name="image" value="{$ally_image}" size="70"></td>
        </tr>
        <tr>
          <td>{$al_manage_requests}</td>
          <td>{html_options name=request_notallow options=$RequestSelector selected=$ally_request_notallow}</td>
        </tr>
        <tr>
          <td>{$al_manage_founder_rank}</td>
          <td><input type="text" name="owner_range" value="{$ally_owner_range}" size="30"></td>
        </tr>
        <tr>
          <td>{$al_view_stats}</td>
          <td>{html_options name=stats options=$YesNoSelector selected=$ally_stats_data}</td>
        </tr>
        <tr>
          <td>{$al_view_diplo}</td>
          <td>{html_options name=diplo options=$YesNoSelector selected=$ally_diplo_data}</td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="options" value="{$al_save}"></td>
        </tr>
    </table>
    </form>
     <table style="width:50%">
     	<tr>
        	<th>{$al_disolve_alliance}</th>
        </tr>
        <tr>
          <td><form action="?page=alliance&amp;mode=admin&amp;edit=exit" method="POST"><input type="submit" value="{$al_continue}" onclick="return confirm('{$al_close_ally}');"></form></td>
        </tr>  
     </table>
     <table style="width:50%">
     	<tr>
        	<th>{$al_transfer_alliance}</th>
        </tr>
        <tr>
          <td><input type="button" onclick="javascript:location.href='game.php?page=alliance&amp;mode=admin&amp;edit=transfer';" value="{$al_continue}"></td>
        </tr>  
     </table>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}