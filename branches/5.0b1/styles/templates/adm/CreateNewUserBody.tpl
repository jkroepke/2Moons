<script>document.body.style.overflow = "auto";</script>
<style>input{text-align:center;}.red{color:#FF3300;}</style>
<body>
<form action="" method="post">
<table width="45%">
<tr><td class="c" colspan="2">{new_title}</td></tr>
<tr><th>{new_name}</th><th><input type="text" name="name"></th></tr>
<tr><th>{new_pass}</th><th><input type="password" name="password"></th></tr>
<tr><th>{new_email}</th><th><input type="text" name="email"></th></tr>
<tr><th>{new_coord}</th><th>
<input type="text" name="galaxy" size="1" maxlength="1"> :
<input type="text" name="system" size="3" maxlength="3"> :
<input type="text" name="planet" size="2" maxlength="2"></th></tr>
<tr><th>{new_range}</th>
<th><select name="authlevel">
<option value="0">{new_range_0}</option>
<option value="1">{new_range_1}</option>
<option value="2">{new_range_2}</option>
<option value="3">{new_range_3}</option>
</select></th></tr>
<tr><th colspan="2"><input type="submit" value="{new_add_user}"></th></tr>
{display}
</table>
</form>
</body>