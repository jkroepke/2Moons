{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_manage_alliance}</td>
        </tr>
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights">{$al_manage_ranks}</a></th>
        </tr>
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members">{$al_manage_members}</a></th>
        </tr>
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=tag">{$al_manage_change_tag}</a></th>
        </tr>
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=name">{$al_manage_change_name}</a></th>
        </tr>
		{if $righthand}
        <tr>
          <th colspan="2"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=diplo">{$al_manage_diplo}</a></th>
        </tr>
		{/if}
    </table>
    <form action="" method="POST">
    <input type="hidden" name="t" value="{$t}">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="3">{$al_texts}</td>
        </tr>
        <tr>
          <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=1">{$al_outside_text}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=2">{$al_inside_text}</a></th>
          <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=3">{$al_request_text}</a></th>
        </tr>
        <tr>
          <td class="c" colspan="3">{$al_message} (<span id="cntChars">0</span> / 5000 {$al_characters})</td>
        </tr>
        <tr>
          <th colspan="3"><textarea name="text" id="text" cols="70" rows="15" onkeyup="$('#cntChars').text($('#text').val().length);" class="tinymce">{$text}</textarea>
		  <br><a href="javascript:edit();">Load Editor</a>
        </th>
        </tr>
        <tr>
          <th colspan="3">
          <input type="reset" value="{$al_circular_reset}"> 
          <input type="submit" value="{$al_save}">
          </th>
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_manage_options}</td>
        </tr>
        <tr>
          <th>{$al_web_site}</th>
          <th><input type="text" name="web" value="{$ally_web}" size="70"></th>
        </tr>
        <tr>
          <th>{$al_manage_image}</th>
          <th><input type="text" name="image" value="{$ally_image}" size="70"></th>
        </tr>
        <tr>
          <th>{$al_manage_requests}</th>
          <th>{html_options name=request_notallow options=$RequestSelector selected=$ally_request_notallow}</th>
        </tr>
        <tr>
          <th>{$al_manage_founder_rank}</th>
          <th><input type="text" name="owner_range" value="{$ally_owner_range}" size="30"></th>
        </tr>
        <tr>
          <th>{$al_view_stats}</th>
          <th>{html_options name=stats options=$YesNoSelector selected=$ally_stats_data}</th>
        </tr>
        <tr>
          <th>{$al_view_diplo}</th>
          <th>{html_options name=diplo options=$YesNoSelector selected=$ally_diplo_data}</th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" name="options" value="{$al_save}"></th>
        </tr>
    </table>
    </form>
     <table width="519" align="center">
     	<tr>
        	<td class="c">{$al_disolve_alliance}</td>
        </tr>
        <tr>
          <th><form action="?page=alliance&amp;mode=admin&amp;edit=exit" method="POST"><input type="submit" value="{$al_continue}" onclick="return confirm('{$al_close_ally}');"></form></th>
        </tr>  
     </table>
     <table width="519" align="center">
     	<tr>
        	<td class="c">{$al_transfer_alliance}</td>
        </tr>
        <tr>
          <th><input type="button" onclick="javascript:location.href='game.php?page=alliance&amp;mode=admin&amp;edit=transfer';" value="{$al_continue}"></th>
        </tr>  
     </table>
</div>
<script type="text/javascript" src="scripts/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript">
function edit(){
	$(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : 'scripts/tinymce/tiny_mce.js',

			// General options
			theme : "advanced",
			skin : "o2k7",
			skin_variant : "black",
			plugins : "bbcode",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,fontselect,fontsizeselect,removeformat,cleanup,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
		});
	});
}
</script>

<script type="text/javascript">$('#cntChars').text($('#text').val().length);</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}