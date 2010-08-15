{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
    <table class="table519">
        <tr>
          <th colspan="2">{$caso} {$al_change_title}</th>
        </tr>
        <tr>
          <td>{$caso_titulo}</td>
          <td><input type="text" name="newname"> <input type="submit" value="{$al_change_submit}"></td>
        </tr>
        <tr>
          <th colspan="9"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></th>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}