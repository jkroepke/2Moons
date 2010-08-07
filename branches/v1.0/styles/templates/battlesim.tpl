{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
{literal}
<script type="text/javascript">
	function add(){
		$("#battlesim").attr('action', '?page=battlesim&action=moreslots');
		$("#battlesim").attr('method', 'POST');
		$("#battlesim").submit();
		return true;
	}
	
	function check(){
		var kb = window.open("about:blank", "kb", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width="+(xsize-100)+",height="+(ysize-100)+",screenX="+((xsize-(xsize-100))/2)+",screenY="+((ysize-(ysize-100))/2)+",top="+((ysize-(ysize-100))/2)+",left="+((xsize-(xsize-100))/2));
		$("#submit:visible").removeAttr('style').hide().fadeOut();
		$("#wait:hidden").removeAttr('style').hide().fadeIn();
		$.post('?page=battlesim&action=send', $('#battlesim').serialize(), function(data){
			data	= $.trim(data);
			if(data.length == 32) {
				kb.focus();
				kb.location.href = 'CombatReport.php?raport='+data;
			} else {
				kb.window.close();
				alert(data);
			}
		});
		
		setTimeout(function(){$("#submit:hidden").removeAttr('style').hide().fadeIn();}, 10000);
		setTimeout(function(){$("#wait:visible").removeAttr('style').hide().fadeOut();}, 10000);
		return true;
	}
	
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});

		// tabs init with a custom tab template and an "add" callback filling in the content
		var $tabs = $('#tabs').tabs({
			tabTemplate: '<li><a href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
		});
	
	
		$('#tabs span.ui-icon-close').live('click', function() {
			var index = $('li',$tabs).index($(this).parent());
			$tabs.tabs('remove', index);
		});
	});

	</script>
{/literal}
<form id="battlesim" name="battlesim">
<input type="hidden" name="slots" id="slots" value="{$Slots + 1}">
<table width="80%" align="center">
<tr><td class="c" colspan="2">{$lm_battlesim}</td></tr>
<tr><td class="c" colspan="2" style="text-align:center;">{$bs_steal}  {$Metal}: <input type="text" size="10" value="{if $battleinput.0.1.1}{$battleinput.0.1.1}{else}0{/if}" name="battleinput[0][1][1]"> {$Crystal}: <input type="text" size="10" value="{if $battleinput.0.1.2}{$battleinput.0.1.2}{else}0{/if}" name="battleinput[0][1][2]"> {$Deuterium}: <input type="text" size="10" value="{if $battleinput.0.1.3}{$battleinput.0.1.3}{else}0{/if}" name="battleinput[0][1][3]"></td></tr>
<tr><td class="c" colspan="2"><input type="button" onClick="return add();" value="Add AKS-Slot"></td></tr>
<tr>
<td>
<div id="tabs">
<ul>
{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">AKS-Slot {$smarty.section.tab.index + 1}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>{/section}
</ul>
{section name=content start=0 loop=$Slots}
<div id="tabs-{$smarty.section.content.index}">
<table align="center">
<tr><td class="c">{$bs_techno}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
<tr>
<th>{$attack_tech}:</th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.109}{$battleinput.{$smarty.section.content.index}.0.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][109]"></th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.109}{$battleinput.{$smarty.section.content.index}.1.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][109]"></th>
</tr>
<tr>
<th>{$shield_tech}:</th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.110}{$battleinput.{$smarty.section.content.index}.0.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][110]"></th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.110}{$battleinput.{$smarty.section.content.index}.1.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][110]"></th>
</tr>
<tr>
<th>{$tank_tech}:</th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.111}{$battleinput.{$smarty.section.content.index}.0.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][111]"></th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.111}{$battleinput.{$smarty.section.content.index}.1.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][111]"></th>
</tr>
</table>
<br>
<table align="center">
<tr><td width="50%">
<table align="center">
<tbody>
<tr><td class="c">{$bs_names}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
{foreach item=name key=id from=$GetFleet}
<tr>
<th>{$name}:</th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.$id}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></th>
</tr>
{/foreach}
</table>
</td>{if $smarty.section.content.index == 0}<td width="50%">
<table align="center">
<tr><td class="c">{$bs_names}</td><td class="c">{$bs_atter}</td><td class="c">{$bs_deffer}</td></tr>
{foreach item=name key=id from=$GetDef}
<tr>
<th>{$name}:</th><th>-</th><th><input type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></th>
</tr>
{/foreach}
</tbody>
</table>
</td>{/if}</tr></table>
</div>
{/section}
</div>
</td>
</tr>
<tr id="submit">
<th colspan="3"><input type="button" onClick="return check();" value="{$bs_send}">&nbsp;<input type="reset" value="{$bs_cancel}"></th>
</tr>
<tr id="wait" style="display:none;">
<th colspan="3" style="height:20px">{$bs_wait}</th>
</tr>
</table>
<br>
<br>
</form>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}