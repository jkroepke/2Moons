{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
	<form action="game.php?page=alliance&amp;mode=admin&amp;edit=transfer" method="POST">
    <table class="table519">
        <tr>
          <th colspan="8">{$al_transfer_alliance}</th>
        </tr>
      	<tr>
			<td>{$al_transfer_to}:</td>
			<td>{html_options name=newleader options=$TransferUsers}</td>
			<td><input type="submit" value="{$al_transfer_submit}"></td>
		</tr>
        <tr>
          <th colspan="3"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></th>
        </tr>
    </table>
	</form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}