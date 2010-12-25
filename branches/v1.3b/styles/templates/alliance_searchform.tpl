{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="POST">
        <table class="table519">
            <tr>
                <th colspan="2">{$al_find_alliances}</th>
            </tr>
            <tr>
                <td>{$al_find_text}</td>
                <td><input type="text" name="searchtext" value="{$searchtext}"> <input type="submit" value="{$al_find_submit}"></td>
            </tr>
        </table>
    </form>
	{if is_array($SeachResult)}
	<table class="table519">
        <tr>
            <th>{$al_ally_info_tag}</th>
            <th>{$al_ally_info_name}</th>
            <th>{$al_ally_info_members}</th>
        </tr>
		{foreach item=SeachRow from=$SeachResult}
        <tr>
			<td><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$SeachRow.id}">{$SeachRow.tag}</a></td>
			<td>{$SeachRow.name}</td>
			<td>{$SeachRow.members}</td>
		</tr>
		{foreachelse}
        <tr>
			<td colspan="3">{$al_find_no_alliances}</td>
		</tr>
		{/foreach}
    </table>
	{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}