<script src="scripts/cntchar.js" type="text/javascript"></script>
<br />
<div id="content">
    <table width="519" align="center" align="center">
        <tr>
          <td class=c colspan=2>{al_manage_alliance}</td>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=rights">{al_manage_ranks}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=members">{al_manage_members}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=tag">{al_manage_change_tag}</a></th>
        </tr>
        <tr>
          <th colspan=2><a href="game.php?page=alliance&mode=admin&edit=name">{al_manage_change_name}</a></th>
        </tr>
    </table>
    <form action="" method="POST">
    <input type="hidden" name="t" value="{t}">
    <table width="519" align="center">
        <tr>
          <td class="c" colspan="3">{al_texts}</td>
        </tr>
        <tr>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=1">{al_outside_text}</a></th>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=2">{al_inside_text}</a></th>
          <th><a href="game.php?page=alliance&mode=admin&edit=ally&t=3">{al_request_text}</a></th>
        </tr>
        <tr>
          <td class=c colspan=3>{al_message} (<span id="cntChars">0</span> / 5000 {al_characters})</td>
        </tr>
        <tr>
          <th colspan="3"><textarea name="text" cols=70 rows=15 onkeyup="javascript:cntchar(5000)">{text}</textarea>
    {request_type}
        </th>
        </tr>
        <tr>
          <th colspan=3>
          <input type="hidden" name=t value={t}><input type="reset" value="{al_circular_reset}"> 
          <input type="submit" value="{al_save}">
          </th>
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table width="519" align="center">
        <tr>
          <td class=c colspan=2>{al_manage_options}</td>
        </tr>
        <tr>
          <th>{al_web_site}</th>
          <th><input type=text name="web" value="{ally_web}" size="70"></th>
        </tr>
        <tr>
          <th>{al_manage_image}</th>
          <th><input type=text name="image" value="{ally_image}" size="70"></th>
        </tr>
        <tr>
          <th>{al_manage_requests}</th>
          <th>
          <select name="request_notallow"><option value=1{ally_request_notallow_0}>{al_requests_not_allowed}</option>
          <option value=0{ally_request_notallow_1}>{al_requests_allowed}</option></select>
          </th>
        </tr>
        <tr>
          <th>{al_manage_founder_rank}</th>
          <th><input type="text" name="owner_range" value="{ally_owner_range}" size=30></th>
        </tr>
        <tr>
          <th>{al_view_stats}</th>
          <th><input name="allystats" {ally_stats_data} type="checkbox" /></th>
        </tr>
        <tr>
          <th colspan=2><input type="submit" name="options" value="{al_save}"></th>
        </tr>
    </table>
    </form>
     <table width="519" align="center">
     	<tr>
        	<td class="c">{al_disolve_alliance}</td>
        </tr>
        <tr>
          <th><input type="button" onclick="javascript:location.href='game.php?page=alliance&mode=admin&edit=exit';" value="{al_continue}"/></th>
        </tr>  
     </table>
     <table width="519" align="center">
     	<tr>
        	<td class="c">{al_transfer_alliance}</td>
        </tr>
        <tr>
          <th><input type="button" onclick="javascript:location.href='game.php?page=alliance&mode=admin&edit=transfer';" value="{al_continue}"/></th>
        </tr>  
     </table>
</div>