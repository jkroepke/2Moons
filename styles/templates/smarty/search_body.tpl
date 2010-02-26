{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <form action="" method="post">
     <table width="519" align="center">
      <tr>
       <td class="c">{$sh_search_in_the_universe}</td>
      </tr>
      <tr>
       <th>
		{html_options name=type options=$SeachTypes selected=$SeachType}
        <input type="text" name="searchtext" value="{$SeachInput}">
        <input type="submit" value="{$sh_search}">
       </th>
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
{if $is_pmenu == 1}
{include file="planet_menu.tpl"}
{/if}
{include file="overall_footer.tpl"}