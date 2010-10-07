{include file="adm/overall_header.tpl"}
<script type="text/javascript" src="./scripts/animatedcollapse.js"></script>
<script type="text/javascript">
animatedcollapse.addDiv('search', 'fade=1,height=auto')
animatedcollapse.ontoggle=function($, divobj, state){
}
animatedcollapse.init()
</script>
<form action="" method="POST">
<table width="90%">
<tr>
<td>
<input type="checkbox" {$minimize} name="minimize"><input type="submit" value="{$se_contrac}" class="button">
<img src="./styles/images/Adm/GO.png" onClick="javascript:animatedcollapse.toggle('search')" style="cursor:pointer;padding-right:60px;" onMouseOver='return overlib("{$ac_minimize_maximize}", CENTER, OFFSETX, 120, OFFSETY, 5, WIDTH, 200);' onMouseOut='return nd();'>
</td>
</tr>
</table>
<div id="search"{$diisplaay}>
<table width="90%">
	<tr>
		<td class="c" colspan="8">
			{$se_search_title}
		</td>
	</tr>
	<tr>
		<th>
			{$se_intro}
		</th>
		<th>
			{$se_type_typee}
		</th>
		<th>
			{$se_search_in}
		</th>
		<th>
			{$se_filter_title}
		</th>
		<th>
			{$se_limit}
		</th>
		<th>
			{$se_asc_desc}
		</th>
		{if $OrderBYParse}
		<th>
			{$se_search_order}
		</th>
		{/if}
		<th>
			&nbsp;
		</th>
	</tr>
<tr>
	<th>
		<input type="text" name="key_user" value="{$search}">
	</th>
	<th>
		{html_options name=search options=$Selector.list selected=$SearchFile}
	</th>
	<th>
		{html_options name=search_in options=$Selector.search selected=$SearchFor}
	</th>
	<th>
		{html_options name=fucki options=$Selector.filter selected=$SearchMethod}
	</th>
	<th>
		{html_options name=limit options=$Selector.limit selected=$limit}
	</th>
	<th>
		{html_options name=key_acc options=$Selector.order selected=$OrderBY}
	</th>
	{if $OrderBYParse}
	<th>
		{html_options name=key_order options=$OrderBYParse selected=$Order}
	</th>
	{/if}
	<th>
		<input type="submit" value="{$se_search}">
	</th>
</tr>
{if !empty($error)}
<tr>
	<th colspan="8">
		<span style="color:red">{$error}</span>
	</th>
</tr>
{/if}
</table>
</div>
<br>
<table width="90%" border="0px" style="background:url(../styles/images/Adm/blank.gif);">
{$PAGES}
</table>
{$LIST}
<br>
<table width="90%" border="0px" style="background:url(../styles/images/Adm/blank.gif);">
{$PAGES}
</table>
</form>