{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<form action="game.php?page=alliance&amp;mode=admin&amp;edit=transfer" method="POST">
    <table width="520" align="center">
        <tr>
          <td class="c" colspan="8">{$al_transfer_alliance}</td>
        </tr>
      	<tr>
			<th colspan="3">{$al_transfer_to}:</th>
			<th>{html_options name=newleader options=$TransferUsers}</th>
			<th colspan="3"><input type="submit" value="{$al_transfer_submit}"></th>
		</tr>
        <tr>
          <td class="c" colspan="8"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></td>
        </tr>
    </table>
	</form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}