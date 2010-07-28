{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content">
    <form action="game.php?page=alliance&amp;mode=apply&amp;allyid={$allyid}&amp;action=send" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_write_request}</td>
        </tr>
        <tr>
          <th width="40%">{$al_message}</th>
          <th><textarea name="text" cols="40" rows="10" onkeyup="javascript:cntchar(6000)">{$applytext}</textarea></th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" name="enviar" value="{$al_applyform_send}"> <input type="submit" name="enviar" value="{$al_applyform_reload}"></th>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}