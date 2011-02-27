{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="post">
     <table style="width:50%">
      <tr>
       <th>{$sh_search_in_the_universe}</th>
      </tr>
      <tr>
       <td>
		{html_options name=type options=$SeachTypes selected=$SeachType}
        <input type="text" name="searchtext" value="{$SeachInput}">
        <input type="submit" value="{$sh_search}">
       </td>
      </tr>
    </table>
    </form>

{if $SeachType}
{if $SeachType == "playername" || $SeachType == "planetname"}
{include file="search_user_result.tpl"}
{else}
{include file="search_ally_result.tpl"}
{/if}
{/if}
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}