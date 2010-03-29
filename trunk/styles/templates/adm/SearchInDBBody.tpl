<script>document.body.style.overflow = "auto";</script>
<body>
<!DOCTYPE HTML>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/animatedcollapse.js"></script>
<script type="text/javascript">
animatedcollapse.addDiv('search', 'fade=1,height=auto')
animatedcollapse.ontoggle=function($, divobj, state){
}
animatedcollapse.init()
</script>
<style>
.button{background:url(images/Adm/blank.gif);border:1px lime solid;color:#FFFFFF;}
.button:hover{background:url(images/Adm/blank.gif);border:1px aqua solid;cursor:pointer;color:#FFFFFF;}
.span{ vertical-align:baseline}</style>

<form action="" method="GET">
<div align="left">
<input type="checkbox" {minimize} name="minimize"/><input type="submit" value="{se_contrac}" class="button"/>
<img src="../styles/images/Adm/GO.png" onClick="javascript:animatedcollapse.toggle('search')" style="cursor:pointer;padding-right:60px;"
onMouseOver='return overlib("{ac_minimize_maximize}", CENTER, OFFSETX, 120, OFFSETY, 5, WIDTH, 200);' onMouseOut='return nd();'>
</div>

<div id="search" style="display:{diisplaay};">
<table width="100%" style="border-collapse: collapse">
	<tr style="border:0px;">
		<td class="c" colspan="8">
			{se_search_title}
		</td>
	</tr>
	<th>
		{se_intro}
	</th>
	<th>
		{se_type_typee}
	</th>
	<th>
		{se_search_in}
	</th>
	<th>
		{se_filter_title}
	</th>
	<th>
		{se_limit}
	</th>
	<th>
		{se_asc_desc}
	</th>
	{ORDER_BY_TITLE}
	<th></th>
</tr><tr>
	<th>
		<input type="text" name="key_user" value="{Key}">
	</th>
	<th>
		<select name="search">
			{OPT_LIST}
		</select>
	</th>
	<th>
		<select name="search_in">
			{OPT_SEARCH}
		</select>
	</th>
	<th>
		<select name="fuki">
			{EXT_LIST}
		</select>
	</th>
	<th>
		<select name="Limit">
			{LIMIT}
		</select>
	</th>
	<th>
		<select name="key_acc">
			{ORDER}
		</select>
	</th>
	{ORDER_BY}
	<th>
		<input type="submit" value="{se_search}">
	</th>
</tr><tr>
	<th colspan="8">
		<font color="red">{error}</font>
	</th>
</tr>
</table>
</div>
<br>
{display}
{TPL_ROW}
</form>
<p align="center">{TimeToCreatePage}</p>
</body>
