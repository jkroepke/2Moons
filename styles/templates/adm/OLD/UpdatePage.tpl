{include file="overall_header.tpl"}
<form action="" method="POST">
<table width="800">
<tr>
<th>{$up_version}</th>
</tr>
<tr>
<td><label for="version">{$up_version}</label>: <input type="text" name="version" size="8" value="{$version}" id="version"> <input type="submit" value="{$up_submit}"></td>
</tr>
<tr>
<td><a href="?page=update&amp;history">History</a></td>
</tr>
</table>
</form>
<script type="text/javascript">
var CurrentVersion	= {$Rev};
RevList			= {$RevList};
var up_submit		= '{$up_submit}';
var up_revision		= '{$up_revision}';
var up_add			= '{$up_add}';
var up_edit			= '{$up_edit}';
var up_del			= '{$up_del}';
var ml_from			= '{$ml_from}';
var up_download		= '{$up_download}';
var up_last			= '{$up_aktuelle_updates}';
var up_current		= '{$up_momentane_version}';
var up_old			= '{$up_alte_updates}';
var canDownload		= {$canDownload};
DisplayUpdates();
</script>
{include file="overall_footer.tpl"}