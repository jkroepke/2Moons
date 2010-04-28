soundManager.flashVersion = 9;
soundManager.url = 'scripts';
soundManager.debugMode = false;
soundManager.useHighPerformance = true;
soundManager.defaultOptions.volume = 33;
soundManager.onload = function() {
var loginbgm = soundManager.createSound({
		id: 'aSound',
		url: 'scripts/bgm_login.mp3',
		volume: 50
	});
	if($.cookie('music') == null || $.cookie('music') == "on"){
		loginbgm.play();
		$('#music').text("Music: ON");
	}
}

function music() {
	var loginbgm = soundManager.getSoundById('aSound');
	var idmusic = $('#music');
	if(idmusic.text() != "Music: ON")
	{
		loginbgm.play();
		idmusic.text("Music: ON");
		$.cookie('music', 'on');
	}
	else
	{
		loginbgm.stop();
		idmusic.text("Music: OFF");
		$.cookie('music', 'off');
	}
}

function ajax(url){
	if(url == '?page=reg&getajax=1'){
		if(IsRegActive == 1){
			alert(lang_reg_closed);  
		} else {
			$.get(url, function(data){
				$('#background-content').html(data);
			});
		}
	} else {
		$.get(url, function(data){
			$('#background-content').html(data);
		});
	}
}

$(document).ready(function(){
	$("#background-content").ajaxStart(function () {
		$("#body").mask("Loading...");
	});
				
	$("#background-content").ajaxStop(function () {
		$("#body").unmask();
	});
});

function changeAction(type) {
    if ($('#Uni').val() == '') {
        alert($("#Uni :selected").text());
		return false;
    } else {
        switch(type){
			case "login":
				document.login.action = $('#Uni').val();
			break;
			case "reg":
				document.reg.action = $('#Uni').val() + "?page=reg&mode=send";
			break;
			case "lostpassword":
				document.lostpassword.action = $('#Uni').val() + "?page=lostpassword&mode=send";
			break;
		}
		return true;
    }
}

function showRecaptcha(element) 
{
	Recaptcha.create(cappublic, 'display_captcha', {
		theme: 'custom',
		lang: 'de',
		tabindex: '4',
		custom_theme_widget: 'display_captcha'
	});
}

function fbLogincheck() {
	FB.Connect.requireSession(function() {
		FB.Facebook.apiClient.users_hasAppPermission('email', function (permsare) { 
			if(!permsare){
				FB.Connect.showPermissionDialog('email', function(perms) {
					if (perms) {
						document.location = $('#Uni').val()+"index.php?page=facebook";
					} else {
						alert(fb_permissions);
					}
				});
			} else {
				document.location = $('#Uni').val()+"index.php?page=facebook";
			}
		});
	});
}

/* UTIL *****************************************************************/

//return an element by id, or object reference
function getElement(obj){
	if (typeof(obj) == "string"){
		
		if (document.getElementById == undefined || !document.getElementById)
		return false;
	
		obj = document.getElementById(obj);	
	}
	
	if (obj == undefined || !obj)
		return false;
	
	return obj;
}

function toggle (obj, displayType, state){
	if (displayType == null || displayType == undefined)
		displayType = "block";

	obj = getElement(obj);

	if (!obj)
		return false;

	if (state != null && state != undefined){
		if (state)
			obj.style.display = displayType;
		else
			obj.style.display = "none";

	}else{
		if (!obj.style.display || obj.style.display == "none")
			obj.style.display = displayType;
		else
			obj.style.display = "none";
	}
}

function show(obj, displayType){
	toggle(obj, displayType, true);
}

function hide(obj, displayType){
	toggle(obj, displayType, false);
}




//take an object, or get an object with the given id, and set it's css class (if no class_name is specified, then restore the element's original class)
function setClass (obj, class_name){
	
	obj = getElement(obj);
	
	if (!obj)
		return false;
	
	if (class_name == undefined || class_name == null){
		if (obj.originalClassName == undefined || !obj.originalClassName)
			obj.originalClassName = "";
		
		obj.className = obj.originalClassName;
	}else{
		obj.originalClassName = obj.className;
		obj.className = class_name;
	}
	
	return true;
}

//cancel bubbling (propagation) of events (call from an event handler, such as onclick="cancelEvent(event);")
function cancelEvent(e){
	
	if (e && e.stopPropagation && e.preventDefault){
		if (e.stopPropagation)
			e.stopPropagation();
			
		if (e.preventDefault)
			e.preventDefault();
	}else if (window.event){
		window.event.cancelBubble = true;
		window.event.returnValue = false;
	}
}


/* TESTS/CHECKS *****************************************************************/

//return true if the browser supports the specified flash version (or greater)
function hasFlash (version){
	
	if (!exists(navigator) || !exists(navigator.plugins) || !exists(navigator.mimeTypes))
		return false;
	
	if (navigator.plugins.length > 0){ //test firefox, netscape, etc
	
		var plugin = navigator.plugins["Shockwave Flash"];
		
		if (!exists(plugin) || parseInt(plugin.description.substr(plugin.description.lastIndexOf(".")-2)) < version)
			return false;
		
	}else if (exists(ActiveXObject)){ //test IE
		
		var e, flashVersion;
		
		try { 
			var axObj = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
			flashVersion = axObj.GetVariable("$version");
		} catch (e) {
			return false;
		}
		
		if (!flashVersion)
			return false;
			
		flashVersion = parseInt(flashVersion.substr(flashVersion.indexOf(" "), flashVersion.indexOf(",") - flashVersion.indexOf(" ")));
		
		if (flashVersion < version)
			return false;
			
	}else
		return false;
	
	return true;
}

//return true if a variable exists (is defined)
function exists (obj){
	if (typeof (obj) != "undefined" && obj != null)
		return true;
		
	return false;
}

//return true if the current browser is IE (or with similar javascript capabilities)
function isIE (){
	if (exists(document) && exists(document.body) && exists(document.body.insertAdjacentHTML) && exists(document.createElement))
		return true;
	
	return false;
}




/* GAME SPECIFIC *****************************************************************/

//hilite a row on mouse over
function rowOver(obj){
	obj = getElement(obj);
	
	if (!obj)
		return false;
		
	if (obj.className != undefined && obj.className != "")
		return false;
	
	setClass (obj, "row_over");
}

//restore the row's previous class on mouse out
function rowOut(obj){
	obj = getElement(obj);
	
	if (!obj)
		return false;
		
	if (obj.className != "row_over")
		return false;
	
	setClass (obj);
}

//mark a row as active (or inactive if the value is 0)
function rowActive(row, input){
	
	input = getElement(input);
	
	if (!input)
		return false;
	
	if (parseInt(input.value) > 0)
		setClass (row, "row_active");
	else
		setClass (row, "");
}


//emulate a button click
function buttonClick(url, target, e){
	if (!exists(url) || url == "")
		return false;
	
	if (exists(e) && (e.ctrlKey || e.button == 1))
		if (target == "")
			target = "_blank";
	
	if (exists(target) && target != "")
		window.open (url, target);
	else
		document.location = url;
		
	if (exists(e))
		cancelEvent(e);
}

//change class of an object on mouse over
function buttonOver(obj, class_name){
	
	if (!class_name || class_name == "" || class_name == undefined)
		class_name = "button button-over";
	
	setClass (obj, class_name);
}

//change class of an object on mouse out
function buttonOut(obj){
	setClass (obj);
}
