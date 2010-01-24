    <table width="519" align="center">
        <tr>
          <td class="c">{$sh_name}</td>
          <td class="c">&nbsp;</td>
          <td class="c">{$sh_alliance}</td>
          <td class="c">{$sh_planet}</td>
          <td class="c">{$sh_coords}</td>
          <td class="c">{$sh_position}</td>
        </tr>

{foreach item=SearchInfo from=$SearchResult}
<tr>
     <th><a href="javascript:playercard('game.php?page=playercard&amp;id={$SearchInfo.userid}');">{$SearchInfo.username}</a></th>
     <th><a href="javascript:f('game.php?page=messages&amp;mode=write&amp;id={$SearchInfo.userid}','');" title="{$sh_write_message}"><img src="{$dpath}img/m.gif"/></a>&nbsp;<a href="javascript:f('game.php?page=buddy&amp;mode=2&amp;u={$SearchInfo.userid}','');" title="{$sh_buddy_request}"><img src="{$dpath}img/b.gif" border="0"></a></th>
     <th>{if {$SearchInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$SearchInfo.allyid}">{$SearchInfo.allyname}</a>{else}-{/if}</th>
     <th>{$SearchInfo.planetname}</th>
     <th><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$SearchInfo.galaxy}&amp;system={$SearchInfo.system}">[{$SearchInfo.galaxy}:{$SearchInfo.system}:{$SearchInfo.planet}]</a></th>
     <th>{$SearchInfo.rank}</th>
</tr>
{/foreach}
    </table>