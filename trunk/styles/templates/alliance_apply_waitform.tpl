{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="2">{$al_your_request_title}</td>
        </tr>
        <tr>
          <th colspan="2">{$request_text}</th>
        </tr>
        <tr>
          <th colspan="2"><input type="submit" name="bcancel" value="{$button_text}"></th>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}