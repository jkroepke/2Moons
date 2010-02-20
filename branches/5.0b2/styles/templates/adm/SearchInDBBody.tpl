<script>document.body.style.overflow = "auto";</script>
<body>
<form action="" method="POST">
<table width="60%">
<tr><td class="c" colspan="3">{se_search_title}</td></tr>
<tr>
<th>{se_intro}</th>
<th>{se_filter}</th>
<th></th>
</tr>
<tr>
<th><input type="text" name="key_user" value="{key}"></th>
<th>
<select name="search">
<option value="user" {selected_u}>{se_users}</option>
<option value="planet" {selected_p}>{se_planets}</option>
<option value="moon" {selected_m}>{se_moons}</option>
<option value="ally" {selected_a}>{se_allys}</option>
<option value="vacation" {selected_v}>{se_vacations}</option>
<option value="suspended" {selected_b}>{se_suspended}</option>
<option value="admin" {selected_s}>{se_authlevels}</option>
<option value="inactives" {selected_i}>{se_inactives}</option>
</select>
</th>
<th><input type="submit" value="{se_search}"></th></tr>
<tr><th colspan="3"><font color=red>{error}</font></th></tr>
</table>
<br>
{orderby}
</form>


<br>
{table1}
{table2}
{table3}
</body>