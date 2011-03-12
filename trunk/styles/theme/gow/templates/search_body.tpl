{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
<table style="width:50%">
	<tr>
		<th>{$sh_search_in_the_universe}</th>
	</tr>
	<tr>
		<td>
			<select name="type" id="type">{html_options options=$SeachTypes selected=$SeachType}</select>
			<input type="text" name="searchtext" id="searchtext" value="{$SeachInput}">
			<input type="button" value="{$sh_search}">
		</td>
	</tr>
</table>
	<div id="result">

	</div>
</div>

<script type="text/javascript">
LNG	= {$language};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}