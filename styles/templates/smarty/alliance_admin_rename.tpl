{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$caso} {$al_change_title}</td>
        </tr>
        <tr>
          <th>{$caso_titulo}</th>
          <th><input type="text" name="newname"> <input type="submit" value="{$al_change_submit}"></th>
        </tr>
        <tr>
          <td class="c" colspan="9"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally">{$al_back}</a></td>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}