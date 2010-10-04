    <table style="width:50%">
        <tr>
          <th>{$sh_name}</th>
          <th>&nbsp;</th>
          <th>{$sh_alliance}</th>
          <th>{$sh_planet}</th>
          <th>{$sh_coords}</th>
          <th>{$sh_position}</th>
        </tr>

{foreach item=SearchInfo from=$SearchResult}
<tr>
     <td><a href="javascript:OpenPopup('game.php?page=playercard&amp;id={$SearchInfo.userid}', '', 640, 510);">{$SearchInfo.username}</a></td>
     <td><a href="javascript:OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$SearchInfo.userid}', '', 720, 300);" title="{$sh_write_message}"><img src="{$dpath}img/m.gif"/></a>&nbsp;<a href="javascript:OpenPopup('game.php?page=buddy&amp;mode=2&amp;u={$SearchInfo.userid}','', 720, 300);" title="{$sh_buddy_request}"><img src="{$dpath}img/b.gif" border="0"></a></td>
     <td>{if {$SearchInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$SearchInfo.allyid}">{$SearchInfo.allyname}</a>{else}-{/if}</td>
     <td>{$SearchInfo.planetname}</td>
     <td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$SearchInfo.galaxy}&amp;system={$SearchInfo.system}">[{$SearchInfo.galaxy}:{$SearchInfo.system}:{$SearchInfo.planet}]</a></td>
     <td>{$SearchInfo.rank}</td>
</tr>
{/foreach}
    </table>