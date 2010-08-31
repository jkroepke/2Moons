{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
        <table class="table519">
        <tr>
          <th>{$al_your_request_title}</th>
        </tr>
        <tr>
          <td>{$request_text}</td>
        </tr>
        <tr>
          <td><input type="submit" name="bcancel" value="{$button_text}"></td>
        </tr>
    </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}