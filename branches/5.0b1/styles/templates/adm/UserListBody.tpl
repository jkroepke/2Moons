<script>document.body.style.overflow = "auto";</script> 
{show_edit_form}
<h2>{adm_ul_title}</h2>
<table width="700">
<tr>
        <td class="c" colspan="12">{adm_ul_ttle2}</td>
</tr>
<tr>
        <th><a href="?cmd=sort&type=id">{ul_id}</a></th>
        <th><a href="?cmd=sort&type=username">{ul_user}</a></th>
        <th><a href="?cmd=sort&type=galaxy">{ul_hp}</a></th>
        <th><a href="?cmd=sort&type=email">{ul_email}</a></th>
        <th><a href="?cmd=sort&type=user_lastip">{ul_last_ip}</a></th>
        <th><a href="?cmd=sort&type=ip_at_reg">{ul_reg_ip}</a></th>
        <th><a href="?cmd=sort&type=register_time">{ul_reg_ip}</a></th>
        <th><a href="?cmd=sort&type=onlinetime">{ul_last_visit}</a></th>
        <th><a href="?cmd=sort&type=bana">{ul_state}</a></th>
        <th><a href="?cmd=sort&type=urlaubs_modus">{ul_umode}</a></th>
        <th>{ul_delete}</th>
        <th>{ul_maintrace}</th>
</tr>
{adm_ul_table}
<tr>
<th class="b" colspan="12">{ul_there_are} {adm_ul_count} {ul_total_players}</th>
</tr>
</table>