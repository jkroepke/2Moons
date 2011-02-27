{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <form action="game.php?page=alliance&amp;mode=apply&amp;allyid={$allyid}&amp;action=send" method="POST">
    <table class="table519">
        <tr>
          <th colspan="2">{$al_write_request}</th>
        </tr>
        <tr>
          <td width="40%">{$al_message}</td>
          <td><textarea name="text" cols="40" rows="10">{$applytext}</textarea></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="enviar" value="{$al_applyform_send}"> <input type="submit" name="enviar" value="{$al_applyform_reload}"></td>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}