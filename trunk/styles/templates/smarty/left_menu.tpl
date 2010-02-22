<div id='leftmenu'>
<div id='menu'>
<p class="p">
{$servername}&nbsp;(<a href="?page=changelog">{$smarty.const.VERSION}</a>)
</p>
<p style="position: absolute; top: -8px; left: 3px; z-index: 1000;">
{if $new_message}
<a href="?page=messages"><img src="{$dpath}img/new_mess.gif" title="" alt="" style="width:16px;height:14px;"></a>
{/if}
{if $incoming_fleets > 0}
<a href="?page=overview"><img src="{$dpath}img/attack.gif" title="" alt="" style="width:16px;height:14px;"></a>
{/if}
</p>
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
{if $authlevel > 0}
<tr>
<td>
<div align="center">
<a href="javascript:top.location.href='adm/index.php'"><font color="lime">{$lm_administration}</font></a>
</div>
</td>
</tr>
{/if}
{foreach key=piclink item=menudiv from=$menu}
<tr>
<td>
<img src="{$dpath}{$piclink}" width="110" height="40" alt="">
</td>
</tr>
{foreach key=link item=name from=$menudiv}
<tr>
<td>
<div align="center">
<a href="{$link}"><font color="white">{$name}</font></a>
</div>
</td>
</tr>
{/foreach}
{/foreach}
</tbody>
</table>
</div>
</div>
<!-- END LEFTMENU -->	