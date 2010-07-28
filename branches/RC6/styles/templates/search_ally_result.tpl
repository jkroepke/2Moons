    <table width="519" align="center">
        <tr>
          <td class="c">{$sh_tag}</td>
          <td class="c">{$sh_name}</td>
          <td class="c">{$sh_members}</td>
          <td class="c">{$sh_points}</td>
        </tr>

{foreach item=SearchInfo from=$SearchResult}
<tr>
  <th><a href="game.php?page=alliance&amp;mode=ainfo&amp;tag={$SearchInfo.allytag}">{$SearchInfo.allytag}</a></th>
  <th>{$SearchInfo.allyname}</th>
  <th>{$SearchInfo.allymembers}</th>
  <th>{$SearchInfo.allypoints}</th>
</tr>
{/foreach}
    </table>