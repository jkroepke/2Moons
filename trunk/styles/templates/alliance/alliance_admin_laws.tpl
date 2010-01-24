<br />
<div id="content">
    <table width="519" align="center" align="center"><tr><td class="c" colspan="11">{al_configura_ranks}</td></tr>
        {list}
    </table>
    <br>
    <form action="game.php?page=alliance&mode=admin&edit=rights&add=name" method="POST">
    <table width="519" align="center" align="center">
        <tr>
          <td class="c" colspan="2">{al_create_new_rank}</td>
        </tr>
        <tr>
          <th>{al_rank_name}</th>
          <th><input type="text" name="newrangname" size="20" maxlength="30"></th>
        </tr>
        <tr>
          <th colspan=2><input type="submit" value="{al_create}"></th>
        </tr>
    </table>
    </form>
    <form action="game.php?page=alliance&mode=admin&edit=rights" method="POST">
    <table width="519" align="center" align="center">
        <tr>
          <td class=c colspan="2">{al_legend}</td>
        </tr>
        <tr>
          <th><img src=styles/images/r1.png></th>
          <th>{al_legend_disolve_alliance}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r2.png></th>
          <th>{al_legend_kick_users}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r3.png></th>
          <th>{al_legend_see_requests}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r4.png></th>
          <th>{al_legend_see_users_list}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r5.png></th>
          <th>{al_legend_check_requests}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r6.png></th>
          <th>{al_legend_admin_alliance}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r7.png></th>
          <th>{al_legend_see_connected_users}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r8.png></th>
          <th>{al_legend_create_circular}</th>
        </tr>
        <tr>
          <th><img src=styles/images/r9.png></th>
          <th>{al_legend_right_hand}</th>
        </tr>
        <tr>
          <td class="c" colspan="2"><a href="game.php?page=alliance&mode=admin&edit=ally">{al_back}</a></td>
        </tr>
    </table>
    </form>
</div>