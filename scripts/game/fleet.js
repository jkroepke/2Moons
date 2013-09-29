function updateScreen()
{
    window.clearInterval(endDateInterval);

    $('#distance').text(NumberGetHumanReadable(missionData.data.distance));
    $('#duration').text(getFormatedTime(missionData.data.flyTime));
    $('#maxspeed').text(NumberGetHumanReadable(missionData.data.fleetMaxSpeed));
    $('#storage').text(NumberGetHumanReadable(missionData.fleetRoom - missionData.data.consumptionTotal));


    $.each(missionData.data.consumption, function(elementId, value) {
        $('#consumption_'+elementId).text(NumberGetHumanReadable(value));
    });

    endDateInterval = window.setInterval(endDates, 1000);
    endDates();
}

function updateData()
{
    var getParameter = $.param({
        'token'             : $('input[name="token"]').val(),
        'fleetSpeed'        : $('#fleetSpeed').val(),
        'planetPosition'    : {
            'galaxy' : $('#targetGalaxy').val(),
            'system' : $('#targetSystem').val(),
            'planet' : $('#targetPlanet').val(),
            'type' : $('#targetType').val(),
        }
    });

    $.getJSON('game.php?page=fleetStep1&mode=getMissionData&'+getParameter, function(data) {
        missionData.data = data;
        updateScreen()
    });
}

function endDates()
{
    var startTime = missionData.data.flyTime;
    var endTime	= startTime + missionData.data.flyTime;
    $("#arrival").html(getFormatedDate(serverTime.getTime() + 1000 * startTime, tdformat));
    $("#return").html(getFormatedDate(serverTime.getTime() + 1000 * endTime, tdformat));
}

function setTarget(e)
{
    e.preventDefault();

    $('#targetGalaxy').val($(this).data('galaxy'));
    $('#targetSystem').val($(this).data('system'));
    $('#targetPlanet').val($(this).data('planet'));
    $('#targetType').val($(this).data('type'));

    updateData();
    return false;
}

function setFleetGroup(e)
{
    e.preventDefault();

    $('#fleetGroup').val($(this).data('fleetGroup'));
    return false;
}






function maxResource(id) {
	var thisresource = getRessource(id);
	var thisresourcechosen = parseInt(document.getElementsByName(id)[0].value);
	if (isNaN(thisresourcechosen)) {
		thisresourcechosen = 0;
	}
	if (isNaN(thisresource)) {
		thisresource = 0;
	}
	
	var storCap = data.fleetroom - data.consumption;

	if (id == 'deuterium') {
		thisresource -= data.consumption;
	}
	var metalToTransport = parseInt(document.getElementsByName("metal")[0].value);
	var crystalToTransport = parseInt(document.getElementsByName("crystal")[0].value);
	var deuteriumToTransport = parseInt(document.getElementsByName("deuterium")[0].value);
	if (isNaN(metalToTransport)) {
		metalToTransport = 0;
	}
	if (isNaN(crystalToTransport)) {
		crystalToTransport = 0;
	}
	if (isNaN(deuteriumToTransport)) {
		deuteriumToTransport = 0;
	}
	var freeCapacity = Math.max(storCap - metalToTransport - crystalToTransport - deuteriumToTransport, 0);
	document.getElementsByName(id)[0].value = Math.min(freeCapacity + thisresourcechosen, thisresource);
	calculateTransportCapacity();
}


function maxResources() {
	maxResource('metal');
	maxResource('crystal');
	maxResource('deuterium');
}

function calculateTransportCapacity() {
	var metal = Math.abs(document.getElementsByName("metal")[0].value);
	var crystal = Math.abs(document.getElementsByName("crystal")[0].value);
	var deuterium = Math.abs(document.getElementsByName("deuterium")[0].value);
	transportCapacity = data.fleetroom - data.consumption - metal - crystal - deuterium;
	if (transportCapacity < 0) {
		document.getElementById("remainingresources").innerHTML = "<font color=red>" + NumberGetHumanReadable(transportCapacity) + "</font>";
	} else {
		document.getElementById("remainingresources").innerHTML = "<font color=lime>" + NumberGetHumanReadable(transportCapacity) + "</font>";
	}
	return transportCapacity;
}

function checkTarget(e)
{
    e.preventDefault();

    var getParameter = $.param({
        'token'  : $('input[name="token"]').val(),
        'galaxy' : $('#targetGalaxy').val(),
        'system' : $('#targetSystem').val(),
        'planet' : $('#targetPlanet').val(),
        'type'   : $('#targetType').val()
    });

    $this = $(this);

	$.getJSON('game.php?page=fleetStep1&mode=checkTarget&'+getParameter, function(error) {
		if(error == false) {
            $this[0].submit();
		} else {
			NotifyBox(error);
		}
	});

	return false;
}















function EditShortcuts() {
    $(".shortcut-link").hide();
    $(".shortcut-edit:not(.shortcut-new)").show();
    if($('.shortcut-isset').length === 0)
    {
        AddShortcuts();
    }
}

function AddShortcuts() {
    var HTML	= $('.shortcut-new td:first').clone().children();
    HTML.find('input, select').attr('name', function(i, old) {
        return old.replace("shortcut[]", "shortcut["+($('.shortcut-link').length)+"-new]");
    });

    var nextFreeColum	= $('.shortcut-row:last td:not(.shortcut-isset):first');

    if(nextFreeColum.length == 0) {
        if($('.shortcut-row:last').length)
        {
            var newRow			= $('<tr />').addClass('shortcut-row').insertAfter('.shortcut-row:last');
            for (var i = 1; i <= shortCutRows; i++) {
                newRow.append('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp</td>');
            }

            var nextFreeColum	= $('.shortcut-row:last td:first');
        } else {
            var newRow			= $('<tr />').addClass('shortcut-row').insertAfter('.shortcut-none');
            for (var i = 1; i <= shortCutRows; i++) {
                newRow.append('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp;</td>');
            }

            var nextFreeColum	= $('.shortcut-row:last td:first');
            $('.shortcut-none').remove();
        }
    }

    nextFreeColum.html(HTML).addClass("shortcut-isset");
}

function SaveShortcuts(reedit) {
    $.getJSON('game.php?page=fleetStep1&mode=saveShortcuts&ajax=1&'+$('.shortcut-row').find("input, select").serialize(), function(res) {
        $(".shortcut-link").show();
        $(".shortcut-edit").hide();

        $shortCutIsset = $(".shortcut-isset");

        var deadElements	= $shortCutIsset.filter(function() {
            return $('input[name*=name]', this).val() == "" ||
                $('input[name*=galaxy]', this).val() == "" || $('input[name*=galaxy]', this).val() == 0 ||
                $('input[name*=system]', this).val() == "" || $('input[name*=system]', this).val() == 0 ||
                $('input[name*=planet]', this).val() == "" || $('input[name*=planet]', this).val() == 0;
        });

        if(deadElements.length % 2 === 1) {
            deadElements.remove();
            $(".shortcut-colum:last").after('<td class="shortcut-colum" style="width:'+(100 / shortCutRows)+'%">&nbsp;</td>');
        }

        $shortCutIsset.unwrap();

        var activeElements	= Math.ceil($shortCutIsset.length / shortCutRows);

        if(activeElements === 0) {
            $('<tr style="height:20px;" class="shortcut-none"><td colspan="'+shortCutRows+'">'+fl_no_shortcuts+'</td></tr>').insertAfter('.shortcut tr:first');
        } else {
            for (var i = 1; i <= activeElements; i++) {
                $('<tr />').addClass('shortcut-row').insertAfter('.shortcut tr:first');
            }

            $(".shortcut-colum").each(function(i, val) {
                $(this).appendTo('tr.shortcut-row:eq('+Math.floor(i / 3)+')');
            });

            $('.shortcut-colum').filter(function() {
                return $(this).parent().is(':not(tr)')
            }).remove();

            $('.shortcut-row').filter(function() {
                return !$(this).children('.shortcut-isset').length;
            }).remove();

            $shortCutIsset.children('.shortcut-link').html(function() {
                if($(this).nextAll().find('input[name*=name]').val() === "") {
                    $(this).parent().html("&nbsp;");
                    return false;
                }
                var Data	= $(this).nextAll();
                return '<a class="setTarget" data-galaxy="'+Data.find('input[name*=galaxy]').val()+'" data-system="'+Data.find('input[name*=system]').val()+'" data-planet="'+Data.find('input[name*=planet]').val()+'" data-type="'+Data.find('select[name*=type]').val()+'">'+Data.find('input[name*=name]').val()+'('+Data.nextAll().find('select[name*=type] option:selected').text()[0]+') ['+Data.find('input[name*=galaxy]').val()+':'+Data.find('input[name*=system]').val()+':'+Data.find('input[name*=planet]').val()+']</a>';
            });
        }

        $('.shortcut-row:has(td:not(.shortcut-isset) + td)').remove();

        if(typeof reedit === "undefinded" || reedit !== true) {
            NotifyBox(res);
        } else {
            if($(".shortcut-isset").length) {
                EditShortcuts();
            }
        }
    });
}

$(function() {
    $('.shortcut-delete').live('click', function() {
        $(this).prev().val('');
        $(this).parent().find('input');
        SaveShortcuts(true);
    });
});