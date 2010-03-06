{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
        <table width="519" align="center">
            <tr>
                <td class="c" colspan="2">{$al_find_alliances}</td>
            </tr>
            <tr>
                <th>{$al_find_text}</th>
                <th><input type="text" name="searchtext" value="{$searchtext}"> <input type="submit" value="{$al_find_submit}"></th>
            </tr>
        </table>
    </form>
	{if is_array($SeachResult)}
	<table width="519" align="center">
        <tr>
            <td class="c">{$al_ally_info_tag}</td>
            <td class="c">{$al_ally_info_name}</td>
            <td class="c">{$al_ally_info_members}</td>
        </tr>
		{foreach item=SeachRow from=$SeachResult}
        <tr>
			<th><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$SeachRow.id}">{$SeachRow.tag}</a></th>
			<th>{$SeachRow.name}</th>
			<th>{$SeachRow.members}</th>
		</tr>
		{foreachelse}
        <tr>
			<th colspan="3">{$al_find_no_alliances}</th>
		</tr>
		{/foreach}
    </table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}