{include file="adm/overall_header.tpl"}
<script type="text/javascript" src="scripts/mbContainer.js"></script>
<script type="text/javascript" src="scripts/update.js"></script>
<form action="?page=update&amp;action=update" method="POST">
<div id="demoContainer" class="containerPlus { buttons:'c', skin:'black', width:'580', height:'150',dock:'dock',closed:'true'}" style="position:absolute;top:250px;left:400px;text-align:center;">
<div class="no"><div class="ne"><div class="n">{$up_password_title}</div></div>
  <div class="o"><div class="e"><div class="c">
	<div class="mbcontainercontent">
	{$up_password_info}<br>
	<label for="password">{$up_password_label}</label> <input type="password" id="password" name="password" autocomplete="off" style="text-align:left;"><br>
	<input type="submit" value="{$up_submit}">
	</div>
  </div></div></div>
  <div>
	<div class="so"><div class="se"><div class="s"> </div></div></div>
  </div>
</div>
</div>
</form>
<form action="" method="POST">
<table width="800">
<tr>
<th>{$up_version}</th>
</tr>
<tr>
<td>{$up_version}: <input type="text" name="version" size="8" value="{$version}"> <input type="submit" value="{$up_submit}"></td>
</tr>
{$Update}
{$Info}
{$RevList}
<tr>
<td><a href="?page=update&amp;action=history">History</a></td>
</tr>
</table>
</form>
{include file="adm/overall_footer.tpl"}