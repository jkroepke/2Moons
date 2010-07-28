{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
   <form action="game.php?page=alliance&amp;mode=make&amp;action=send" method="POST">
        <table width="519" align="center">
            <tr>
                <td class="c" colspan=2>{$al_make_alliance}</td>
            </tr>
            <tr>
                <th>{$al_make_ally_tag_required}</th>
                <th><input type="text" name="atag" size="8" maxlength="8" value=""></th>
            </tr>
            <tr>
                <th>{$al_make_ally_name_required}</th>
                <th><input type="text" name="aname" size="20" maxlength="30" value=""></th>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="{$al_make_submit}"></th>
            </tr>
        </table>
    </form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}