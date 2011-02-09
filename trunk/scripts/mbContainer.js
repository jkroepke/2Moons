/*!
 * jQuery UI 1.8.9
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI
 */
(function(c,j){function k(a){return!c(a).parents().andSelf().filter(function(){return c.curCSS(this,"visibility")==="hidden"||c.expr.filters.hidden(this)}).length}c.ui=c.ui||{};if(!c.ui.version){c.extend(c.ui,{version:"1.8.9",keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,
NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91}});c.fn.extend({_focus:c.fn.focus,focus:function(a,b){return typeof a==="number"?this.each(function(){var d=this;setTimeout(function(){c(d).focus();b&&b.call(d)},a)}):this._focus.apply(this,arguments)},scrollParent:function(){var a;a=c.browser.msie&&/(static|relative)/.test(this.css("position"))||/absolute/.test(this.css("position"))?this.parents().filter(function(){return/(relative|absolute|fixed)/.test(c.curCSS(this,
"position",1))&&/(auto|scroll)/.test(c.curCSS(this,"overflow",1)+c.curCSS(this,"overflow-y",1)+c.curCSS(this,"overflow-x",1))}).eq(0):this.parents().filter(function(){return/(auto|scroll)/.test(c.curCSS(this,"overflow",1)+c.curCSS(this,"overflow-y",1)+c.curCSS(this,"overflow-x",1))}).eq(0);return/fixed/.test(this.css("position"))||!a.length?c(document):a},zIndex:function(a){if(a!==j)return this.css("zIndex",a);if(this.length){a=c(this[0]);for(var b;a.length&&a[0]!==document;){b=a.css("position");
if(b==="absolute"||b==="relative"||b==="fixed"){b=parseInt(a.css("zIndex"),10);if(!isNaN(b)&&b!==0)return b}a=a.parent()}}return 0},disableSelection:function(){return this.bind((c.support.selectstart?"selectstart":"mousedown")+".ui-disableSelection",function(a){a.preventDefault()})},enableSelection:function(){return this.unbind(".ui-disableSelection")}});c.each(["Width","Height"],function(a,b){function d(f,g,l,m){c.each(e,function(){g-=parseFloat(c.curCSS(f,"padding"+this,true))||0;if(l)g-=parseFloat(c.curCSS(f,
"border"+this+"Width",true))||0;if(m)g-=parseFloat(c.curCSS(f,"margin"+this,true))||0});return g}var e=b==="Width"?["Left","Right"]:["Top","Bottom"],h=b.toLowerCase(),i={innerWidth:c.fn.innerWidth,innerHeight:c.fn.innerHeight,outerWidth:c.fn.outerWidth,outerHeight:c.fn.outerHeight};c.fn["inner"+b]=function(f){if(f===j)return i["inner"+b].call(this);return this.each(function(){c(this).css(h,d(this,f)+"px")})};c.fn["outer"+b]=function(f,g){if(typeof f!=="number")return i["outer"+b].call(this,f);return this.each(function(){c(this).css(h,
d(this,f,true,g)+"px")})}});c.extend(c.expr[":"],{data:function(a,b,d){return!!c.data(a,d[3])},focusable:function(a){var b=a.nodeName.toLowerCase(),d=c.attr(a,"tabindex");if("area"===b){b=a.parentNode;d=b.name;if(!a.href||!d||b.nodeName.toLowerCase()!=="map")return false;a=c("img[usemap=#"+d+"]")[0];return!!a&&k(a)}return(/input|select|textarea|button|object/.test(b)?!a.disabled:"a"==b?a.href||!isNaN(d):!isNaN(d))&&k(a)},tabbable:function(a){var b=c.attr(a,"tabindex");return(isNaN(b)||b>=0)&&c(a).is(":focusable")}});
c(function(){var a=document.body,b=a.appendChild(b=document.createElement("div"));c.extend(b.style,{minHeight:"100px",height:"auto",padding:0,borderWidth:0});c.support.minHeight=b.offsetHeight===100;c.support.selectstart="onselectstart"in b;a.removeChild(b).style.display="none"});c.extend(c.ui,{plugin:{add:function(a,b,d){a=c.ui[a].prototype;for(var e in d){a.plugins[e]=a.plugins[e]||[];a.plugins[e].push([b,d[e]])}},call:function(a,b,d){if((b=a.plugins[b])&&a.element[0].parentNode)for(var e=0;e<b.length;e++)a.options[b[e][0]]&&
b[e][1].apply(a.element,d)}},contains:function(a,b){return document.compareDocumentPosition?a.compareDocumentPosition(b)&16:a!==b&&a.contains(b)},hasScroll:function(a,b){if(c(a).css("overflow")==="hidden")return false;b=b&&b==="left"?"scrollLeft":"scrollTop";var d=false;if(a[b]>0)return true;a[b]=1;d=a[b]>0;a[b]=0;return d},isOverAxis:function(a,b,d){return a>b&&a<b+d},isOver:function(a,b,d,e,h,i){return c.ui.isOverAxis(a,d,h)&&c.ui.isOverAxis(b,e,i)}})}})(jQuery);
;/*!
 * jQuery UI Widget 1.8.9
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Widget
 */
(function(b,j){if(b.cleanData){var k=b.cleanData;b.cleanData=function(a){for(var c=0,d;(d=a[c])!=null;c++)b(d).triggerHandler("remove");k(a)}}else{var l=b.fn.remove;b.fn.remove=function(a,c){return this.each(function(){if(!c)if(!a||b.filter(a,[this]).length)b("*",this).add([this]).each(function(){b(this).triggerHandler("remove")});return l.call(b(this),a,c)})}}b.widget=function(a,c,d){var e=a.split(".")[0],f;a=a.split(".")[1];f=e+"-"+a;if(!d){d=c;c=b.Widget}b.expr[":"][f]=function(h){return!!b.data(h,
a)};b[e]=b[e]||{};b[e][a]=function(h,g){arguments.length&&this._createWidget(h,g)};c=new c;c.options=b.extend(true,{},c.options);b[e][a].prototype=b.extend(true,c,{namespace:e,widgetName:a,widgetEventPrefix:b[e][a].prototype.widgetEventPrefix||a,widgetBaseClass:f},d);b.widget.bridge(a,b[e][a])};b.widget.bridge=function(a,c){b.fn[a]=function(d){var e=typeof d==="string",f=Array.prototype.slice.call(arguments,1),h=this;d=!e&&f.length?b.extend.apply(null,[true,d].concat(f)):d;if(e&&d.charAt(0)==="_")return h;
e?this.each(function(){var g=b.data(this,a),i=g&&b.isFunction(g[d])?g[d].apply(g,f):g;if(i!==g&&i!==j){h=i;return false}}):this.each(function(){var g=b.data(this,a);g?g.option(d||{})._init():b.data(this,a,new c(d,this))});return h}};b.Widget=function(a,c){arguments.length&&this._createWidget(a,c)};b.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",options:{disabled:false},_createWidget:function(a,c){b.data(c,this.widgetName,this);this.element=b(c);this.options=b.extend(true,{},this.options,
this._getCreateOptions(),a);var d=this;this.element.bind("remove."+this.widgetName,function(){d.destroy()});this._create();this._trigger("create");this._init()},_getCreateOptions:function(){return b.metadata&&b.metadata.get(this.element[0])[this.widgetName]},_create:function(){},_init:function(){},destroy:function(){this.element.unbind("."+this.widgetName).removeData(this.widgetName);this.widget().unbind("."+this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass+"-disabled ui-state-disabled")},
widget:function(){return this.element},option:function(a,c){var d=a;if(arguments.length===0)return b.extend({},this.options);if(typeof a==="string"){if(c===j)return this.options[a];d={};d[a]=c}this._setOptions(d);return this},_setOptions:function(a){var c=this;b.each(a,function(d,e){c._setOption(d,e)});return this},_setOption:function(a,c){this.options[a]=c;if(a==="disabled")this.widget()[c?"addClass":"removeClass"](this.widgetBaseClass+"-disabled ui-state-disabled").attr("aria-disabled",c);return this},
enable:function(){return this._setOption("disabled",false)},disable:function(){return this._setOption("disabled",true)},_trigger:function(a,c,d){var e=this.options[a];c=b.Event(c);c.type=(a===this.widgetEventPrefix?a:this.widgetEventPrefix+a).toLowerCase();d=d||{};if(c.originalEvent){a=b.event.props.length;for(var f;a;){f=b.event.props[--a];c[f]=c.originalEvent[f]}}this.element.trigger(c,d);return!(b.isFunction(e)&&e.call(this.element[0],c,d)===false||c.isDefaultPrevented())}}})(jQuery);
;/*!
 * jQuery UI Mouse 1.8.9
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Mouse
 *
 * Depends:
 *	jquery.ui.widget.js
 */
(function(c){c.widget("ui.mouse",{options:{cancel:":input,option",distance:1,delay:0},_mouseInit:function(){var a=this;this.element.bind("mousedown."+this.widgetName,function(b){return a._mouseDown(b)}).bind("click."+this.widgetName,function(b){if(true===c.data(b.target,a.widgetName+".preventClickEvent")){c.removeData(b.target,a.widgetName+".preventClickEvent");b.stopImmediatePropagation();return false}});this.started=false},_mouseDestroy:function(){this.element.unbind("."+this.widgetName)},_mouseDown:function(a){a.originalEvent=
a.originalEvent||{};if(!a.originalEvent.mouseHandled){this._mouseStarted&&this._mouseUp(a);this._mouseDownEvent=a;var b=this,e=a.which==1,f=typeof this.options.cancel=="string"?c(a.target).parents().add(a.target).filter(this.options.cancel).length:false;if(!e||f||!this._mouseCapture(a))return true;this.mouseDelayMet=!this.options.delay;if(!this.mouseDelayMet)this._mouseDelayTimer=setTimeout(function(){b.mouseDelayMet=true},this.options.delay);if(this._mouseDistanceMet(a)&&this._mouseDelayMet(a)){this._mouseStarted=
this._mouseStart(a)!==false;if(!this._mouseStarted){a.preventDefault();return true}}this._mouseMoveDelegate=function(d){return b._mouseMove(d)};this._mouseUpDelegate=function(d){return b._mouseUp(d)};c(document).bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate);a.preventDefault();return a.originalEvent.mouseHandled=true}},_mouseMove:function(a){if(c.browser.msie&&!(document.documentMode>=9)&&!a.button)return this._mouseUp(a);if(this._mouseStarted){this._mouseDrag(a);
return a.preventDefault()}if(this._mouseDistanceMet(a)&&this._mouseDelayMet(a))(this._mouseStarted=this._mouseStart(this._mouseDownEvent,a)!==false)?this._mouseDrag(a):this._mouseUp(a);return!this._mouseStarted},_mouseUp:function(a){c(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate);if(this._mouseStarted){this._mouseStarted=false;a.target==this._mouseDownEvent.target&&c.data(a.target,this.widgetName+".preventClickEvent",
true);this._mouseStop(a)}return false},_mouseDistanceMet:function(a){return Math.max(Math.abs(this._mouseDownEvent.pageX-a.pageX),Math.abs(this._mouseDownEvent.pageY-a.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return true}})})(jQuery);
;/*
 * jQuery UI Draggable 1.8.9
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Draggables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function(d){d.widget("ui.draggable",d.ui.mouse,{widgetEventPrefix:"drag",options:{addClasses:true,appendTo:"parent",axis:false,connectToSortable:false,containment:false,cursor:"auto",cursorAt:false,grid:false,handle:false,helper:"original",iframeFix:false,opacity:false,refreshPositions:false,revert:false,revertDuration:500,scope:"default",scroll:true,scrollSensitivity:20,scrollSpeed:20,snap:false,snapMode:"both",snapTolerance:20,stack:false,zIndex:false},_create:function(){if(this.options.helper==
"original"&&!/^(?:r|a|f)/.test(this.element.css("position")))this.element[0].style.position="relative";this.options.addClasses&&this.element.addClass("ui-draggable");this.options.disabled&&this.element.addClass("ui-draggable-disabled");this._mouseInit()},destroy:function(){if(this.element.data("draggable")){this.element.removeData("draggable").unbind(".draggable").removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled");this._mouseDestroy();return this}},_mouseCapture:function(a){var b=
this.options;if(this.helper||b.disabled||d(a.target).is(".ui-resizable-handle"))return false;this.handle=this._getHandle(a);if(!this.handle)return false;return true},_mouseStart:function(a){var b=this.options;this.helper=this._createHelper(a);this._cacheHelperProportions();if(d.ui.ddmanager)d.ui.ddmanager.current=this;this._cacheMargins();this.cssPosition=this.helper.css("position");this.scrollParent=this.helper.scrollParent();this.offset=this.positionAbs=this.element.offset();this.offset={top:this.offset.top-
this.margins.top,left:this.offset.left-this.margins.left};d.extend(this.offset,{click:{left:a.pageX-this.offset.left,top:a.pageY-this.offset.top},parent:this._getParentOffset(),relative:this._getRelativeOffset()});this.originalPosition=this.position=this._generatePosition(a);this.originalPageX=a.pageX;this.originalPageY=a.pageY;b.cursorAt&&this._adjustOffsetFromHelper(b.cursorAt);b.containment&&this._setContainment();if(this._trigger("start",a)===false){this._clear();return false}this._cacheHelperProportions();
d.ui.ddmanager&&!b.dropBehaviour&&d.ui.ddmanager.prepareOffsets(this,a);this.helper.addClass("ui-draggable-dragging");this._mouseDrag(a,true);return true},_mouseDrag:function(a,b){this.position=this._generatePosition(a);this.positionAbs=this._convertPositionTo("absolute");if(!b){b=this._uiHash();if(this._trigger("drag",a,b)===false){this._mouseUp({});return false}this.position=b.position}if(!this.options.axis||this.options.axis!="y")this.helper[0].style.left=this.position.left+"px";if(!this.options.axis||
this.options.axis!="x")this.helper[0].style.top=this.position.top+"px";d.ui.ddmanager&&d.ui.ddmanager.drag(this,a);return false},_mouseStop:function(a){var b=false;if(d.ui.ddmanager&&!this.options.dropBehaviour)b=d.ui.ddmanager.drop(this,a);if(this.dropped){b=this.dropped;this.dropped=false}if((!this.element[0]||!this.element[0].parentNode)&&this.options.helper=="original")return false;if(this.options.revert=="invalid"&&!b||this.options.revert=="valid"&&b||this.options.revert===true||d.isFunction(this.options.revert)&&
this.options.revert.call(this.element,b)){var c=this;d(this.helper).animate(this.originalPosition,parseInt(this.options.revertDuration,10),function(){c._trigger("stop",a)!==false&&c._clear()})}else this._trigger("stop",a)!==false&&this._clear();return false},cancel:function(){this.helper.is(".ui-draggable-dragging")?this._mouseUp({}):this._clear();return this},_getHandle:function(a){var b=!this.options.handle||!d(this.options.handle,this.element).length?true:false;d(this.options.handle,this.element).find("*").andSelf().each(function(){if(this==
a.target)b=true});return b},_createHelper:function(a){var b=this.options;a=d.isFunction(b.helper)?d(b.helper.apply(this.element[0],[a])):b.helper=="clone"?this.element.clone():this.element;a.parents("body").length||a.appendTo(b.appendTo=="parent"?this.element[0].parentNode:b.appendTo);a[0]!=this.element[0]&&!/(fixed|absolute)/.test(a.css("position"))&&a.css("position","absolute");return a},_adjustOffsetFromHelper:function(a){if(typeof a=="string")a=a.split(" ");if(d.isArray(a))a={left:+a[0],top:+a[1]||
0};if("left"in a)this.offset.click.left=a.left+this.margins.left;if("right"in a)this.offset.click.left=this.helperProportions.width-a.right+this.margins.left;if("top"in a)this.offset.click.top=a.top+this.margins.top;if("bottom"in a)this.offset.click.top=this.helperProportions.height-a.bottom+this.margins.top},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var a=this.offsetParent.offset();if(this.cssPosition=="absolute"&&this.scrollParent[0]!=document&&d.ui.contains(this.scrollParent[0],
this.offsetParent[0])){a.left+=this.scrollParent.scrollLeft();a.top+=this.scrollParent.scrollTop()}if(this.offsetParent[0]==document.body||this.offsetParent[0].tagName&&this.offsetParent[0].tagName.toLowerCase()=="html"&&d.browser.msie)a={top:0,left:0};return{top:a.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:a.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){if(this.cssPosition=="relative"){var a=this.element.position();return{top:a.top-
(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:a.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}}else return{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.element.css("marginLeft"),10)||0,top:parseInt(this.element.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var a=this.options;if(a.containment==
"parent")a.containment=this.helper[0].parentNode;if(a.containment=="document"||a.containment=="window")this.containment=[(a.containment=="document"?0:d(window).scrollLeft())-this.offset.relative.left-this.offset.parent.left,(a.containment=="document"?0:d(window).scrollTop())-this.offset.relative.top-this.offset.parent.top,(a.containment=="document"?0:d(window).scrollLeft())+d(a.containment=="document"?document:window).width()-this.helperProportions.width-this.margins.left,(a.containment=="document"?
0:d(window).scrollTop())+(d(a.containment=="document"?document:window).height()||document.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top];if(!/^(document|window|parent)$/.test(a.containment)&&a.containment.constructor!=Array){var b=d(a.containment)[0];if(b){a=d(a.containment).offset();var c=d(b).css("overflow")!="hidden";this.containment=[a.left+(parseInt(d(b).css("borderLeftWidth"),10)||0)+(parseInt(d(b).css("paddingLeft"),10)||0)-this.margins.left,a.top+(parseInt(d(b).css("borderTopWidth"),
10)||0)+(parseInt(d(b).css("paddingTop"),10)||0)-this.margins.top,a.left+(c?Math.max(b.scrollWidth,b.offsetWidth):b.offsetWidth)-(parseInt(d(b).css("borderLeftWidth"),10)||0)-(parseInt(d(b).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,a.top+(c?Math.max(b.scrollHeight,b.offsetHeight):b.offsetHeight)-(parseInt(d(b).css("borderTopWidth"),10)||0)-(parseInt(d(b).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top]}}else if(a.containment.constructor==
Array)this.containment=a.containment},_convertPositionTo:function(a,b){if(!b)b=this.position;a=a=="absolute"?1:-1;var c=this.cssPosition=="absolute"&&!(this.scrollParent[0]!=document&&d.ui.contains(this.scrollParent[0],this.offsetParent[0]))?this.offsetParent:this.scrollParent,f=/(html|body)/i.test(c[0].tagName);return{top:b.top+this.offset.relative.top*a+this.offset.parent.top*a-(d.browser.safari&&d.browser.version<526&&this.cssPosition=="fixed"?0:(this.cssPosition=="fixed"?-this.scrollParent.scrollTop():
f?0:c.scrollTop())*a),left:b.left+this.offset.relative.left*a+this.offset.parent.left*a-(d.browser.safari&&d.browser.version<526&&this.cssPosition=="fixed"?0:(this.cssPosition=="fixed"?-this.scrollParent.scrollLeft():f?0:c.scrollLeft())*a)}},_generatePosition:function(a){var b=this.options,c=this.cssPosition=="absolute"&&!(this.scrollParent[0]!=document&&d.ui.contains(this.scrollParent[0],this.offsetParent[0]))?this.offsetParent:this.scrollParent,f=/(html|body)/i.test(c[0].tagName),e=a.pageX,g=a.pageY;
if(this.originalPosition){if(this.containment){if(a.pageX-this.offset.click.left<this.containment[0])e=this.containment[0]+this.offset.click.left;if(a.pageY-this.offset.click.top<this.containment[1])g=this.containment[1]+this.offset.click.top;if(a.pageX-this.offset.click.left>this.containment[2])e=this.containment[2]+this.offset.click.left;if(a.pageY-this.offset.click.top>this.containment[3])g=this.containment[3]+this.offset.click.top}if(b.grid){g=this.originalPageY+Math.round((g-this.originalPageY)/
b.grid[1])*b.grid[1];g=this.containment?!(g-this.offset.click.top<this.containment[1]||g-this.offset.click.top>this.containment[3])?g:!(g-this.offset.click.top<this.containment[1])?g-b.grid[1]:g+b.grid[1]:g;e=this.originalPageX+Math.round((e-this.originalPageX)/b.grid[0])*b.grid[0];e=this.containment?!(e-this.offset.click.left<this.containment[0]||e-this.offset.click.left>this.containment[2])?e:!(e-this.offset.click.left<this.containment[0])?e-b.grid[0]:e+b.grid[0]:e}}return{top:g-this.offset.click.top-
this.offset.relative.top-this.offset.parent.top+(d.browser.safari&&d.browser.version<526&&this.cssPosition=="fixed"?0:this.cssPosition=="fixed"?-this.scrollParent.scrollTop():f?0:c.scrollTop()),left:e-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+(d.browser.safari&&d.browser.version<526&&this.cssPosition=="fixed"?0:this.cssPosition=="fixed"?-this.scrollParent.scrollLeft():f?0:c.scrollLeft())}},_clear:function(){this.helper.removeClass("ui-draggable-dragging");this.helper[0]!=
this.element[0]&&!this.cancelHelperRemoval&&this.helper.remove();this.helper=null;this.cancelHelperRemoval=false},_trigger:function(a,b,c){c=c||this._uiHash();d.ui.plugin.call(this,a,[b,c]);if(a=="drag")this.positionAbs=this._convertPositionTo("absolute");return d.Widget.prototype._trigger.call(this,a,b,c)},plugins:{},_uiHash:function(){return{helper:this.helper,position:this.position,originalPosition:this.originalPosition,offset:this.positionAbs}}});d.extend(d.ui.draggable,{version:"1.8.9"});
d.ui.plugin.add("draggable","connectToSortable",{start:function(a,b){var c=d(this).data("draggable"),f=c.options,e=d.extend({},b,{item:c.element});c.sortables=[];d(f.connectToSortable).each(function(){var g=d.data(this,"sortable");if(g&&!g.options.disabled){c.sortables.push({instance:g,shouldRevert:g.options.revert});g._refreshItems();g._trigger("activate",a,e)}})},stop:function(a,b){var c=d(this).data("draggable"),f=d.extend({},b,{item:c.element});d.each(c.sortables,function(){if(this.instance.isOver){this.instance.isOver=
0;c.cancelHelperRemoval=true;this.instance.cancelHelperRemoval=false;if(this.shouldRevert)this.instance.options.revert=true;this.instance._mouseStop(a);this.instance.options.helper=this.instance.options._helper;c.options.helper=="original"&&this.instance.currentItem.css({top:"auto",left:"auto"})}else{this.instance.cancelHelperRemoval=false;this.instance._trigger("deactivate",a,f)}})},drag:function(a,b){var c=d(this).data("draggable"),f=this;d.each(c.sortables,function(){this.instance.positionAbs=
c.positionAbs;this.instance.helperProportions=c.helperProportions;this.instance.offset.click=c.offset.click;if(this.instance._intersectsWith(this.instance.containerCache)){if(!this.instance.isOver){this.instance.isOver=1;this.instance.currentItem=d(f).clone().appendTo(this.instance.element).data("sortable-item",true);this.instance.options._helper=this.instance.options.helper;this.instance.options.helper=function(){return b.helper[0]};a.target=this.instance.currentItem[0];this.instance._mouseCapture(a,
true);this.instance._mouseStart(a,true,true);this.instance.offset.click.top=c.offset.click.top;this.instance.offset.click.left=c.offset.click.left;this.instance.offset.parent.left-=c.offset.parent.left-this.instance.offset.parent.left;this.instance.offset.parent.top-=c.offset.parent.top-this.instance.offset.parent.top;c._trigger("toSortable",a);c.dropped=this.instance.element;c.currentItem=c.element;this.instance.fromOutside=c}this.instance.currentItem&&this.instance._mouseDrag(a)}else if(this.instance.isOver){this.instance.isOver=
0;this.instance.cancelHelperRemoval=true;this.instance.options.revert=false;this.instance._trigger("out",a,this.instance._uiHash(this.instance));this.instance._mouseStop(a,true);this.instance.options.helper=this.instance.options._helper;this.instance.currentItem.remove();this.instance.placeholder&&this.instance.placeholder.remove();c._trigger("fromSortable",a);c.dropped=false}})}});d.ui.plugin.add("draggable","cursor",{start:function(){var a=d("body"),b=d(this).data("draggable").options;if(a.css("cursor"))b._cursor=
a.css("cursor");a.css("cursor",b.cursor)},stop:function(){var a=d(this).data("draggable").options;a._cursor&&d("body").css("cursor",a._cursor)}});d.ui.plugin.add("draggable","iframeFix",{start:function(){var a=d(this).data("draggable").options;d(a.iframeFix===true?"iframe":a.iframeFix).each(function(){d('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({width:this.offsetWidth+"px",height:this.offsetHeight+"px",position:"absolute",opacity:"0.001",zIndex:1E3}).css(d(this).offset()).appendTo("body")})},
stop:function(){d("div.ui-draggable-iframeFix").each(function(){this.parentNode.removeChild(this)})}});d.ui.plugin.add("draggable","opacity",{start:function(a,b){a=d(b.helper);b=d(this).data("draggable").options;if(a.css("opacity"))b._opacity=a.css("opacity");a.css("opacity",b.opacity)},stop:function(a,b){a=d(this).data("draggable").options;a._opacity&&d(b.helper).css("opacity",a._opacity)}});d.ui.plugin.add("draggable","scroll",{start:function(){var a=d(this).data("draggable");if(a.scrollParent[0]!=
document&&a.scrollParent[0].tagName!="HTML")a.overflowOffset=a.scrollParent.offset()},drag:function(a){var b=d(this).data("draggable"),c=b.options,f=false;if(b.scrollParent[0]!=document&&b.scrollParent[0].tagName!="HTML"){if(!c.axis||c.axis!="x")if(b.overflowOffset.top+b.scrollParent[0].offsetHeight-a.pageY<c.scrollSensitivity)b.scrollParent[0].scrollTop=f=b.scrollParent[0].scrollTop+c.scrollSpeed;else if(a.pageY-b.overflowOffset.top<c.scrollSensitivity)b.scrollParent[0].scrollTop=f=b.scrollParent[0].scrollTop-
c.scrollSpeed;if(!c.axis||c.axis!="y")if(b.overflowOffset.left+b.scrollParent[0].offsetWidth-a.pageX<c.scrollSensitivity)b.scrollParent[0].scrollLeft=f=b.scrollParent[0].scrollLeft+c.scrollSpeed;else if(a.pageX-b.overflowOffset.left<c.scrollSensitivity)b.scrollParent[0].scrollLeft=f=b.scrollParent[0].scrollLeft-c.scrollSpeed}else{if(!c.axis||c.axis!="x")if(a.pageY-d(document).scrollTop()<c.scrollSensitivity)f=d(document).scrollTop(d(document).scrollTop()-c.scrollSpeed);else if(d(window).height()-
(a.pageY-d(document).scrollTop())<c.scrollSensitivity)f=d(document).scrollTop(d(document).scrollTop()+c.scrollSpeed);if(!c.axis||c.axis!="y")if(a.pageX-d(document).scrollLeft()<c.scrollSensitivity)f=d(document).scrollLeft(d(document).scrollLeft()-c.scrollSpeed);else if(d(window).width()-(a.pageX-d(document).scrollLeft())<c.scrollSensitivity)f=d(document).scrollLeft(d(document).scrollLeft()+c.scrollSpeed)}f!==false&&d.ui.ddmanager&&!c.dropBehaviour&&d.ui.ddmanager.prepareOffsets(b,a)}});d.ui.plugin.add("draggable",
"snap",{start:function(){var a=d(this).data("draggable"),b=a.options;a.snapElements=[];d(b.snap.constructor!=String?b.snap.items||":data(draggable)":b.snap).each(function(){var c=d(this),f=c.offset();this!=a.element[0]&&a.snapElements.push({item:this,width:c.outerWidth(),height:c.outerHeight(),top:f.top,left:f.left})})},drag:function(a,b){for(var c=d(this).data("draggable"),f=c.options,e=f.snapTolerance,g=b.offset.left,n=g+c.helperProportions.width,m=b.offset.top,o=m+c.helperProportions.height,h=
c.snapElements.length-1;h>=0;h--){var i=c.snapElements[h].left,k=i+c.snapElements[h].width,j=c.snapElements[h].top,l=j+c.snapElements[h].height;if(i-e<g&&g<k+e&&j-e<m&&m<l+e||i-e<g&&g<k+e&&j-e<o&&o<l+e||i-e<n&&n<k+e&&j-e<m&&m<l+e||i-e<n&&n<k+e&&j-e<o&&o<l+e){if(f.snapMode!="inner"){var p=Math.abs(j-o)<=e,q=Math.abs(l-m)<=e,r=Math.abs(i-n)<=e,s=Math.abs(k-g)<=e;if(p)b.position.top=c._convertPositionTo("relative",{top:j-c.helperProportions.height,left:0}).top-c.margins.top;if(q)b.position.top=c._convertPositionTo("relative",
{top:l,left:0}).top-c.margins.top;if(r)b.position.left=c._convertPositionTo("relative",{top:0,left:i-c.helperProportions.width}).left-c.margins.left;if(s)b.position.left=c._convertPositionTo("relative",{top:0,left:k}).left-c.margins.left}var t=p||q||r||s;if(f.snapMode!="outer"){p=Math.abs(j-m)<=e;q=Math.abs(l-o)<=e;r=Math.abs(i-g)<=e;s=Math.abs(k-n)<=e;if(p)b.position.top=c._convertPositionTo("relative",{top:j,left:0}).top-c.margins.top;if(q)b.position.top=c._convertPositionTo("relative",{top:l-c.helperProportions.height,
left:0}).top-c.margins.top;if(r)b.position.left=c._convertPositionTo("relative",{top:0,left:i}).left-c.margins.left;if(s)b.position.left=c._convertPositionTo("relative",{top:0,left:k-c.helperProportions.width}).left-c.margins.left}if(!c.snapElements[h].snapping&&(p||q||r||s||t))c.options.snap.snap&&c.options.snap.snap.call(c.element,a,d.extend(c._uiHash(),{snapItem:c.snapElements[h].item}));c.snapElements[h].snapping=p||q||r||s||t}else{c.snapElements[h].snapping&&c.options.snap.release&&c.options.snap.release.call(c.element,
a,d.extend(c._uiHash(),{snapItem:c.snapElements[h].item}));c.snapElements[h].snapping=false}}}});d.ui.plugin.add("draggable","stack",{start:function(){var a=d(this).data("draggable").options;a=d.makeArray(d(a.stack)).sort(function(c,f){return(parseInt(d(c).css("zIndex"),10)||0)-(parseInt(d(f).css("zIndex"),10)||0)});if(a.length){var b=parseInt(a[0].style.zIndex)||0;d(a).each(function(c){this.style.zIndex=b+c});this[0].style.zIndex=b+a.length}}});d.ui.plugin.add("draggable","zIndex",{start:function(a,
b){a=d(b.helper);b=d(this).data("draggable").options;if(a.css("zIndex"))b._zIndex=a.css("zIndex");a.css("zIndex",b.zIndex)},stop:function(a,b){a=d(this).data("draggable").options;a._zIndex&&d(b.helper).css("zIndex",a._zIndex)}})})(jQuery);
;/*
 * jQuery UI Resizable 1.8.9
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Resizables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function(e){e.widget("ui.resizable",e.ui.mouse,{widgetEventPrefix:"resize",options:{alsoResize:false,animate:false,animateDuration:"slow",animateEasing:"swing",aspectRatio:false,autoHide:false,containment:false,ghost:false,grid:false,handles:"e,s,se",helper:false,maxHeight:null,maxWidth:null,minHeight:10,minWidth:10,zIndex:1E3},_create:function(){var b=this,a=this.options;this.element.addClass("ui-resizable");e.extend(this,{_aspectRatio:!!a.aspectRatio,aspectRatio:a.aspectRatio,originalElement:this.element,
_proportionallyResizeElements:[],_helper:a.helper||a.ghost||a.animate?a.helper||"ui-resizable-helper":null});if(this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)){/relative/.test(this.element.css("position"))&&e.browser.opera&&this.element.css({position:"relative",top:"auto",left:"auto"});this.element.wrap(e('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({position:this.element.css("position"),width:this.element.outerWidth(),height:this.element.outerHeight(),
top:this.element.css("top"),left:this.element.css("left")}));this.element=this.element.parent().data("resizable",this.element.data("resizable"));this.elementIsWrapper=true;this.element.css({marginLeft:this.originalElement.css("marginLeft"),marginTop:this.originalElement.css("marginTop"),marginRight:this.originalElement.css("marginRight"),marginBottom:this.originalElement.css("marginBottom")});this.originalElement.css({marginLeft:0,marginTop:0,marginRight:0,marginBottom:0});this.originalResizeStyle=
this.originalElement.css("resize");this.originalElement.css("resize","none");this._proportionallyResizeElements.push(this.originalElement.css({position:"static",zoom:1,display:"block"}));this.originalElement.css({margin:this.originalElement.css("margin")});this._proportionallyResize()}this.handles=a.handles||(!e(".ui-resizable-handle",this.element).length?"e,s,se":{n:".ui-resizable-n",e:".ui-resizable-e",s:".ui-resizable-s",w:".ui-resizable-w",se:".ui-resizable-se",sw:".ui-resizable-sw",ne:".ui-resizable-ne",
nw:".ui-resizable-nw"});if(this.handles.constructor==String){if(this.handles=="all")this.handles="n,e,s,w,se,sw,ne,nw";var c=this.handles.split(",");this.handles={};for(var d=0;d<c.length;d++){var f=e.trim(c[d]),g=e('<div class="ui-resizable-handle '+("ui-resizable-"+f)+'"></div>');/sw|se|ne|nw/.test(f)&&g.css({zIndex:++a.zIndex});"se"==f&&g.addClass("ui-icon ui-icon-gripsmall-diagonal-se");this.handles[f]=".ui-resizable-"+f;this.element.append(g)}}this._renderAxis=function(h){h=h||this.element;for(var i in this.handles){if(this.handles[i].constructor==
String)this.handles[i]=e(this.handles[i],this.element).show();if(this.elementIsWrapper&&this.originalElement[0].nodeName.match(/textarea|input|select|button/i)){var j=e(this.handles[i],this.element),k=0;k=/sw|ne|nw|se|n|s/.test(i)?j.outerHeight():j.outerWidth();j=["padding",/ne|nw|n/.test(i)?"Top":/se|sw|s/.test(i)?"Bottom":/^e$/.test(i)?"Right":"Left"].join("");h.css(j,k);this._proportionallyResize()}e(this.handles[i])}};this._renderAxis(this.element);this._handles=e(".ui-resizable-handle",this.element).disableSelection();
this._handles.mouseover(function(){if(!b.resizing){if(this.className)var h=this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);b.axis=h&&h[1]?h[1]:"se"}});if(a.autoHide){this._handles.hide();e(this.element).addClass("ui-resizable-autohide").hover(function(){e(this).removeClass("ui-resizable-autohide");b._handles.show()},function(){if(!b.resizing){e(this).addClass("ui-resizable-autohide");b._handles.hide()}})}this._mouseInit()},destroy:function(){this._mouseDestroy();var b=function(c){e(c).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").unbind(".resizable").find(".ui-resizable-handle").remove()};
if(this.elementIsWrapper){b(this.element);var a=this.element;a.after(this.originalElement.css({position:a.css("position"),width:a.outerWidth(),height:a.outerHeight(),top:a.css("top"),left:a.css("left")})).remove()}this.originalElement.css("resize",this.originalResizeStyle);b(this.originalElement);return this},_mouseCapture:function(b){var a=false;for(var c in this.handles)if(e(this.handles[c])[0]==b.target)a=true;return!this.options.disabled&&a},_mouseStart:function(b){var a=this.options,c=this.element.position(),
d=this.element;this.resizing=true;this.documentScroll={top:e(document).scrollTop(),left:e(document).scrollLeft()};if(d.is(".ui-draggable")||/absolute/.test(d.css("position")))d.css({position:"absolute",top:c.top,left:c.left});e.browser.opera&&/relative/.test(d.css("position"))&&d.css({position:"relative",top:"auto",left:"auto"});this._renderProxy();c=m(this.helper.css("left"));var f=m(this.helper.css("top"));if(a.containment){c+=e(a.containment).scrollLeft()||0;f+=e(a.containment).scrollTop()||0}this.offset=
this.helper.offset();this.position={left:c,top:f};this.size=this._helper?{width:d.outerWidth(),height:d.outerHeight()}:{width:d.width(),height:d.height()};this.originalSize=this._helper?{width:d.outerWidth(),height:d.outerHeight()}:{width:d.width(),height:d.height()};this.originalPosition={left:c,top:f};this.sizeDiff={width:d.outerWidth()-d.width(),height:d.outerHeight()-d.height()};this.originalMousePosition={left:b.pageX,top:b.pageY};this.aspectRatio=typeof a.aspectRatio=="number"?a.aspectRatio:
this.originalSize.width/this.originalSize.height||1;a=e(".ui-resizable-"+this.axis).css("cursor");e("body").css("cursor",a=="auto"?this.axis+"-resize":a);d.addClass("ui-resizable-resizing");this._propagate("start",b);return true},_mouseDrag:function(b){var a=this.helper,c=this.originalMousePosition,d=this._change[this.axis];if(!d)return false;c=d.apply(this,[b,b.pageX-c.left||0,b.pageY-c.top||0]);if(this._aspectRatio||b.shiftKey)c=this._updateRatio(c,b);c=this._respectSize(c,b);this._propagate("resize",
b);a.css({top:this.position.top+"px",left:this.position.left+"px",width:this.size.width+"px",height:this.size.height+"px"});!this._helper&&this._proportionallyResizeElements.length&&this._proportionallyResize();this._updateCache(c);this._trigger("resize",b,this.ui());return false},_mouseStop:function(b){this.resizing=false;var a=this.options,c=this;if(this._helper){var d=this._proportionallyResizeElements,f=d.length&&/textarea/i.test(d[0].nodeName);d=f&&e.ui.hasScroll(d[0],"left")?0:c.sizeDiff.height;
f={width:c.size.width-(f?0:c.sizeDiff.width),height:c.size.height-d};d=parseInt(c.element.css("left"),10)+(c.position.left-c.originalPosition.left)||null;var g=parseInt(c.element.css("top"),10)+(c.position.top-c.originalPosition.top)||null;a.animate||this.element.css(e.extend(f,{top:g,left:d}));c.helper.height(c.size.height);c.helper.width(c.size.width);this._helper&&!a.animate&&this._proportionallyResize()}e("body").css("cursor","auto");this.element.removeClass("ui-resizable-resizing");this._propagate("stop",
b);this._helper&&this.helper.remove();return false},_updateCache:function(b){this.offset=this.helper.offset();if(l(b.left))this.position.left=b.left;if(l(b.top))this.position.top=b.top;if(l(b.height))this.size.height=b.height;if(l(b.width))this.size.width=b.width},_updateRatio:function(b){var a=this.position,c=this.size,d=this.axis;if(b.height)b.width=c.height*this.aspectRatio;else if(b.width)b.height=c.width/this.aspectRatio;if(d=="sw"){b.left=a.left+(c.width-b.width);b.top=null}if(d=="nw"){b.top=
a.top+(c.height-b.height);b.left=a.left+(c.width-b.width)}return b},_respectSize:function(b){var a=this.options,c=this.axis,d=l(b.width)&&a.maxWidth&&a.maxWidth<b.width,f=l(b.height)&&a.maxHeight&&a.maxHeight<b.height,g=l(b.width)&&a.minWidth&&a.minWidth>b.width,h=l(b.height)&&a.minHeight&&a.minHeight>b.height;if(g)b.width=a.minWidth;if(h)b.height=a.minHeight;if(d)b.width=a.maxWidth;if(f)b.height=a.maxHeight;var i=this.originalPosition.left+this.originalSize.width,j=this.position.top+this.size.height,
k=/sw|nw|w/.test(c);c=/nw|ne|n/.test(c);if(g&&k)b.left=i-a.minWidth;if(d&&k)b.left=i-a.maxWidth;if(h&&c)b.top=j-a.minHeight;if(f&&c)b.top=j-a.maxHeight;if((a=!b.width&&!b.height)&&!b.left&&b.top)b.top=null;else if(a&&!b.top&&b.left)b.left=null;return b},_proportionallyResize:function(){if(this._proportionallyResizeElements.length)for(var b=this.helper||this.element,a=0;a<this._proportionallyResizeElements.length;a++){var c=this._proportionallyResizeElements[a];if(!this.borderDif){var d=[c.css("borderTopWidth"),
c.css("borderRightWidth"),c.css("borderBottomWidth"),c.css("borderLeftWidth")],f=[c.css("paddingTop"),c.css("paddingRight"),c.css("paddingBottom"),c.css("paddingLeft")];this.borderDif=e.map(d,function(g,h){g=parseInt(g,10)||0;h=parseInt(f[h],10)||0;return g+h})}e.browser.msie&&(e(b).is(":hidden")||e(b).parents(":hidden").length)||c.css({height:b.height()-this.borderDif[0]-this.borderDif[2]||0,width:b.width()-this.borderDif[1]-this.borderDif[3]||0})}},_renderProxy:function(){var b=this.options;this.elementOffset=
this.element.offset();if(this._helper){this.helper=this.helper||e('<div style="overflow:hidden;"></div>');var a=e.browser.msie&&e.browser.version<7,c=a?1:0;a=a?2:-1;this.helper.addClass(this._helper).css({width:this.element.outerWidth()+a,height:this.element.outerHeight()+a,position:"absolute",left:this.elementOffset.left-c+"px",top:this.elementOffset.top-c+"px",zIndex:++b.zIndex});this.helper.appendTo("body").disableSelection()}else this.helper=this.element},_change:{e:function(b,a){return{width:this.originalSize.width+
a}},w:function(b,a){return{left:this.originalPosition.left+a,width:this.originalSize.width-a}},n:function(b,a,c){return{top:this.originalPosition.top+c,height:this.originalSize.height-c}},s:function(b,a,c){return{height:this.originalSize.height+c}},se:function(b,a,c){return e.extend(this._change.s.apply(this,arguments),this._change.e.apply(this,[b,a,c]))},sw:function(b,a,c){return e.extend(this._change.s.apply(this,arguments),this._change.w.apply(this,[b,a,c]))},ne:function(b,a,c){return e.extend(this._change.n.apply(this,
arguments),this._change.e.apply(this,[b,a,c]))},nw:function(b,a,c){return e.extend(this._change.n.apply(this,arguments),this._change.w.apply(this,[b,a,c]))}},_propagate:function(b,a){e.ui.plugin.call(this,b,[a,this.ui()]);b!="resize"&&this._trigger(b,a,this.ui())},plugins:{},ui:function(){return{originalElement:this.originalElement,element:this.element,helper:this.helper,position:this.position,size:this.size,originalSize:this.originalSize,originalPosition:this.originalPosition}}});e.extend(e.ui.resizable,
{version:"1.8.9"});e.ui.plugin.add("resizable","alsoResize",{start:function(){var b=e(this).data("resizable").options,a=function(c){e(c).each(function(){var d=e(this);d.data("resizable-alsoresize",{width:parseInt(d.width(),10),height:parseInt(d.height(),10),left:parseInt(d.css("left"),10),top:parseInt(d.css("top"),10),position:d.css("position")})})};if(typeof b.alsoResize=="object"&&!b.alsoResize.parentNode)if(b.alsoResize.length){b.alsoResize=b.alsoResize[0];a(b.alsoResize)}else e.each(b.alsoResize,
function(c){a(c)});else a(b.alsoResize)},resize:function(b,a){var c=e(this).data("resizable");b=c.options;var d=c.originalSize,f=c.originalPosition,g={height:c.size.height-d.height||0,width:c.size.width-d.width||0,top:c.position.top-f.top||0,left:c.position.left-f.left||0},h=function(i,j){e(i).each(function(){var k=e(this),q=e(this).data("resizable-alsoresize"),p={},r=j&&j.length?j:k.parents(a.originalElement[0]).length?["width","height"]:["width","height","top","left"];e.each(r,function(n,o){if((n=
(q[o]||0)+(g[o]||0))&&n>=0)p[o]=n||null});if(e.browser.opera&&/relative/.test(k.css("position"))){c._revertToRelativePosition=true;k.css({position:"absolute",top:"auto",left:"auto"})}k.css(p)})};typeof b.alsoResize=="object"&&!b.alsoResize.nodeType?e.each(b.alsoResize,function(i,j){h(i,j)}):h(b.alsoResize)},stop:function(){var b=e(this).data("resizable"),a=b.options,c=function(d){e(d).each(function(){var f=e(this);f.css({position:f.data("resizable-alsoresize").position})})};if(b._revertToRelativePosition){b._revertToRelativePosition=
false;typeof a.alsoResize=="object"&&!a.alsoResize.nodeType?e.each(a.alsoResize,function(d){c(d)}):c(a.alsoResize)}e(this).removeData("resizable-alsoresize")}});e.ui.plugin.add("resizable","animate",{stop:function(b){var a=e(this).data("resizable"),c=a.options,d=a._proportionallyResizeElements,f=d.length&&/textarea/i.test(d[0].nodeName),g=f&&e.ui.hasScroll(d[0],"left")?0:a.sizeDiff.height;f={width:a.size.width-(f?0:a.sizeDiff.width),height:a.size.height-g};g=parseInt(a.element.css("left"),10)+(a.position.left-
a.originalPosition.left)||null;var h=parseInt(a.element.css("top"),10)+(a.position.top-a.originalPosition.top)||null;a.element.animate(e.extend(f,h&&g?{top:h,left:g}:{}),{duration:c.animateDuration,easing:c.animateEasing,step:function(){var i={width:parseInt(a.element.css("width"),10),height:parseInt(a.element.css("height"),10),top:parseInt(a.element.css("top"),10),left:parseInt(a.element.css("left"),10)};d&&d.length&&e(d[0]).css({width:i.width,height:i.height});a._updateCache(i);a._propagate("resize",
b)}})}});e.ui.plugin.add("resizable","containment",{start:function(){var b=e(this).data("resizable"),a=b.element,c=b.options.containment;if(a=c instanceof e?c.get(0):/parent/.test(c)?a.parent().get(0):c){b.containerElement=e(a);if(/document/.test(c)||c==document){b.containerOffset={left:0,top:0};b.containerPosition={left:0,top:0};b.parentData={element:e(document),left:0,top:0,width:e(document).width(),height:e(document).height()||document.body.parentNode.scrollHeight}}else{var d=e(a),f=[];e(["Top",
"Right","Left","Bottom"]).each(function(i,j){f[i]=m(d.css("padding"+j))});b.containerOffset=d.offset();b.containerPosition=d.position();b.containerSize={height:d.innerHeight()-f[3],width:d.innerWidth()-f[1]};c=b.containerOffset;var g=b.containerSize.height,h=b.containerSize.width;h=e.ui.hasScroll(a,"left")?a.scrollWidth:h;g=e.ui.hasScroll(a)?a.scrollHeight:g;b.parentData={element:a,left:c.left,top:c.top,width:h,height:g}}}},resize:function(b){var a=e(this).data("resizable"),c=a.options,d=a.containerOffset,
f=a.position;b=a._aspectRatio||b.shiftKey;var g={top:0,left:0},h=a.containerElement;if(h[0]!=document&&/static/.test(h.css("position")))g=d;if(f.left<(a._helper?d.left:0)){a.size.width+=a._helper?a.position.left-d.left:a.position.left-g.left;if(b)a.size.height=a.size.width/c.aspectRatio;a.position.left=c.helper?d.left:0}if(f.top<(a._helper?d.top:0)){a.size.height+=a._helper?a.position.top-d.top:a.position.top;if(b)a.size.width=a.size.height*c.aspectRatio;a.position.top=a._helper?d.top:0}a.offset.left=
a.parentData.left+a.position.left;a.offset.top=a.parentData.top+a.position.top;c=Math.abs((a._helper?a.offset.left-g.left:a.offset.left-g.left)+a.sizeDiff.width);d=Math.abs((a._helper?a.offset.top-g.top:a.offset.top-d.top)+a.sizeDiff.height);f=a.containerElement.get(0)==a.element.parent().get(0);g=/relative|absolute/.test(a.containerElement.css("position"));if(f&&g)c-=a.parentData.left;if(c+a.size.width>=a.parentData.width){a.size.width=a.parentData.width-c;if(b)a.size.height=a.size.width/a.aspectRatio}if(d+
a.size.height>=a.parentData.height){a.size.height=a.parentData.height-d;if(b)a.size.width=a.size.height*a.aspectRatio}},stop:function(){var b=e(this).data("resizable"),a=b.options,c=b.containerOffset,d=b.containerPosition,f=b.containerElement,g=e(b.helper),h=g.offset(),i=g.outerWidth()-b.sizeDiff.width;g=g.outerHeight()-b.sizeDiff.height;b._helper&&!a.animate&&/relative/.test(f.css("position"))&&e(this).css({left:h.left-d.left-c.left,width:i,height:g});b._helper&&!a.animate&&/static/.test(f.css("position"))&&
e(this).css({left:h.left-d.left-c.left,width:i,height:g})}});e.ui.plugin.add("resizable","ghost",{start:function(){var b=e(this).data("resizable"),a=b.options,c=b.size;b.ghost=b.originalElement.clone();b.ghost.css({opacity:0.25,display:"block",position:"relative",height:c.height,width:c.width,margin:0,left:0,top:0}).addClass("ui-resizable-ghost").addClass(typeof a.ghost=="string"?a.ghost:"");b.ghost.appendTo(b.helper)},resize:function(){var b=e(this).data("resizable");b.ghost&&b.ghost.css({position:"relative",
height:b.size.height,width:b.size.width})},stop:function(){var b=e(this).data("resizable");b.ghost&&b.helper&&b.helper.get(0).removeChild(b.ghost.get(0))}});e.ui.plugin.add("resizable","grid",{resize:function(){var b=e(this).data("resizable"),a=b.options,c=b.size,d=b.originalSize,f=b.originalPosition,g=b.axis;a.grid=typeof a.grid=="number"?[a.grid,a.grid]:a.grid;var h=Math.round((c.width-d.width)/(a.grid[0]||1))*(a.grid[0]||1);a=Math.round((c.height-d.height)/(a.grid[1]||1))*(a.grid[1]||1);if(/^(se|s|e)$/.test(g)){b.size.width=
d.width+h;b.size.height=d.height+a}else if(/^(ne)$/.test(g)){b.size.width=d.width+h;b.size.height=d.height+a;b.position.top=f.top-a}else{if(/^(sw)$/.test(g)){b.size.width=d.width+h;b.size.height=d.height+a}else{b.size.width=d.width+h;b.size.height=d.height+a;b.position.top=f.top-a}b.position.left=f.left-h}}});var m=function(b){return parseInt(b,10)||0},l=function(b){return!isNaN(parseInt(b,10))}})(jQuery);
;

/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2010. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: mbicocchi@open-lab.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/*
 * Name:jquery.mb.containerPlus
 * Version: 2.5.1
 * dependencies: UI.core.js, UI.draggable.js, UI.resizable.js
 */

(function($){
  jQuery.fn.buildContainers = function (options){
    return this.each (function (){
      if ($(this).is("[inited=true]")) return;
      this.options = {
        containment:"document",
        elementsPath:"elements/",
        dockedIconDim:35,
        onCreate:function(o){},
        onCollapse:function(o){},
        onBeforeIconize:function(o){},
        onIconize:function(o){},
        onClose: function(o){},
        onBeforeClose: function(o){},
        onResize: function(o){},
        onDrag: function(o){},
        onRestore:function(o){},
        onLoad:function(o){},
        mantainOnWindow:true,
        collapseEffect:"slide", //or "fade"
        effectDuration:300,
        zIndexContext:"auto" // or your selector (ex: ".containerPlus")
      };

      $.extend (this.options, options);

      var el=this;
      if(!el.id) el.id= new Date().getMilliseconds();
      var container=$(this);

      $(window).resize(function(){
        if (container.get(0).options.mantainOnWindow)
          $.doOnWindowResize(el);
      });

      container.attr("inited","true");
      container.attr("iconized","false");
      container.attr("collapsed","false");
      container.attr("closed","false");

      container.attr("options",this.options);

      if (!container.css("position")=="absolute")
        container.css({position: "relative"});

      if ($.metadata){
        $.metadata.setType("class");
        if (container.metadata().skin) container.attr("skin",container.metadata().skin);
        if (container.metadata().collapsed) container.attr("collapsed",container.metadata().collapsed);
        if (container.metadata().iconized) container.attr("iconized",container.metadata().iconized);
        if (container.metadata().icon) container.attr("icon",container.metadata().icon);
        if (container.metadata().buttons) container.attr("buttons",container.metadata().buttons);
        if (container.metadata().content) container.attr("content",container.metadata().content); //ajax
        if (container.metadata().data) container.attr("data",container.metadata().data); //ajax
        if (container.metadata().aspectRatio) container.attr("aspectRatio",container.metadata().aspectRatio); //ui.resize
        if (container.metadata().title) container.attr("containerTitle",container.metadata().title); //ui.resize

        if (container.metadata().grid) container.attr("grid",container.metadata().grid); //ui.grid DRAG
        if (container.metadata().gridx) container.attr("gridx",container.metadata().gridx); //ui.grid DRAG
        if (container.metadata().gridy) container.attr("gridy",container.metadata().gridy); //ui.grid DRAG

        if (container.metadata().resizeGrid) container.attr("resizeGrid",container.metadata().resizeGrid); //ui.grid RESIZE
        if (container.metadata().resizeGridx) container.attr("resizeGridx",container.metadata().resizeGridx); //ui.grid RESIZE
        if (container.metadata().resizeGridy) container.attr("resizeGridy",container.metadata().resizeGridy); //ui.grid RESIZE

        if (container.metadata().handles) container.attr("handles",container.metadata().handles); //ui.resize
        if (container.metadata().dock) container.attr("dock",container.metadata().dock);
        if (container.metadata().closed) container.attr("closed",container.metadata().closed);
        if (container.metadata().rememberMe) container.attr("rememberMe",container.metadata().rememberMe);
        if (container.metadata().isModal) container.attr("isModal",container.metadata().isModal);             // todo
        if (container.metadata().width) container.attr("width",container.metadata().width);
        if (container.metadata().height) container.attr("height",container.metadata().height);
        if (container.metadata().containment) container.attr("containment",container.metadata().containment);
        if (container.metadata().minWidth) container.attr("minWidth",container.metadata().minWidth);
        if (container.metadata().minHeight) container.attr("minHeight",container.metadata().minHeight);

        if (container.metadata().alwaysOnTop) container.css("z-index",100000).addClass("alwaysOnTop");
      }

      if(this.options.onCreate)
        this.options.onCreate(container);


      if (container.attr("rememberMe")=="true"){
        container.attr("width" , container.mb_getCookie("width")!=null? container.mb_getCookie("width"):container.attr("width") );
        container.attr("height", container.mb_getCookie("height")!=null? container.mb_getCookie("height"):container.attr("height") );
        container.attr("closed", container.mb_getCookie("closed")!=null? container.mb_getCookie("closed"):container.attr("closed") );
        container.attr("collapsed", container.mb_getCookie("collapsed")!=null? container.mb_getCookie("collapsed"):container.attr("collapsed") );
        container.attr("iconized", container.mb_getCookie("iconized")!=null? container.mb_getCookie("iconized"):container.attr("iconized") );
        container.css("left", container.mb_getCookie("x")!=null? container.mb_getCookie("x"):container.css("left") );
        container.css("top", container.mb_getCookie("y")!=null? container.mb_getCookie("y"):container.css("top") );
      }

      var isStructured= container.find(".mbcontainercontent").size()>0;
      if(!isStructured){
        var content= container.html();
        container.empty();
        var structure=''+
                '<div class="no"><div class="ne"><div class="n"></div></div>'+
                '<div class="o"><div class="e"><div class="c">'+
                '<div class="mbcontainercontent">'+content+'</div></div>' +
                '</div></div>'+
                '<div><div class="so"><div class="se"><div class="s"> </div></div></div>'+
                '</div></div>';
        container.html(structure);
      }
      if(container.attr("containerTitle")) container.find(".n:first").html(container.attr("containerTitle"));

      if (container.attr("content")){
        var data= container.attr("data")?container.attr("data"):"";
        container.mb_changeContainerContent(container.attr("content"),data);
      }

      container.addClass(container.attr("skin"));
      container.find(".n:first").attr("unselectable","on");
      if (!container.find(".n:first").html()) container.find(".n:first").html("&nbsp;");
      container.containerSetIcon(container.attr("icon"), this.options.elementsPath);
      if (container.attr("buttons")) container.containerSetButtons(container.attr("buttons"),this.options);
      container.css({width:"99.9%"});

      if (container.attr("width")){
        var cw= $.browser.msie? container.attr("width"):container.attr("width")+"px";
        container.css({width:cw});
      }

      if (container.attr("height")){
        container.find(".c:first , .mbcontainercontent:first").css("height",container.attr("height")-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight()));
        container.attr("height","");
        container.css({height:""});

      }else if ($.browser.safari){
        container.find(".mbcontainercontent:first").css("padding-bottom",5);
      }

      var nwh=$(window).height();
      if (container.outerHeight()>nwh)
        container.find(".c:first , .mbcontainercontent:first").css("height",(nwh-20)-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight()));

      if (container.hasClass("draggable")){
        var pos=container.css("position")=="static"?"absolute":container.css("position");
        container.css({position:pos, margin:0});
        container.find(".n:first").css({cursor:"move"});
        container.mb_bringToFront(this.options.zIndexContext);

        container.draggable({
          handle:".n:first",
          delay:0,
          start:function(){},
          stop:function(){
            var opt=$(this).attr("options");
            if(opt.onDrag) opt.onDrag($(this));
            if (container.attr("rememberMe")){
              container.mb_setCookie("x",container.css("left"));
              container.mb_setCookie("y",container.css("top"));
            }
          }
        });
        if (container.attr("grid") || (container.attr("gridx") && container.attr("gridy"))){
          var grid= container.attr("grid")? [container.attr("grid"),container.attr("grid")]:[container.attr("gridx"),container.attr("gridy")];
          container.draggable('option', 'grid', grid);
        }
        container.bind("mousedown",function(){
          $(this).mb_bringToFront(this.options.zIndexContext);
        });
      }
      var opt= container.attr("options");
      if (opt.onLoad) {
        opt.onLoad(container);
      }
      if (container.hasClass("resizable")){
        container.containerResize();
      }
      if (container.attr("collapsed")=="true"){
        container.attr("collapsed","false");
        container.containerCollapse(this.options);
      }
      if (container.attr("iconized")=="true"){
        container.attr("iconized","false");
        container.containerIconize(this.options, true);
      }
      if (container.mb_getState('closed')){
        container.attr("closed","false");
        container.mb_close();
        return;
      }

      // setTimeout(function(){
      if(!$.browser.msie){
        container.css("opacity",0);
        container.css("visibility","visible");
        container.fadeTo(opt.effectDuration,1);
      }else{
        container.css("visibility","visible");
      }
      container.adjastPos();
      container.setContainment();
      //  },10);
    });
  };


  jQuery.fn.setContainment=function(){
    var container=$(this);
    var opt= container.get(0).options;
    var containment=opt.containment;
    if(opt.containment == "document"){
      var dH=($(document).height()-(container.outerHeight()+10));
      var dW=($(document).width()-(container.outerWidth()+10));
      containment= [0,0,dW,dH]; //[x1, y1, x2, y2]
    }
    if(container.is(".draggable") && opt.containment!=""){
      container.draggable('option', 'containment', containment);
    }
    return containment;
  };

  jQuery.fn.containerResize = function (){
    var container=$(this);
    var isDraggable=container.hasClass("draggable");
    var handles= container.attr("handles")?container.attr("handles"):"s";
    var aspectRatio= container.attr("aspectRatio")?container.attr("aspectRatio"):false;
    var minWidth= container.attr("minWidth")?container.attr("minWidth"):350;
    var minHeight= container.attr("minHeight")?container.attr("minHeight"):150;

    container.resizable({
      handles:isDraggable ? "":handles,
      aspectRatio:aspectRatio,
      minWidth: minWidth ,
      minHeight: minHeight,
      iframeFix:true,
      helper: "mbproxy",
      start:function(e,o){
        var elH= container.attr("containment")?container.parents().height():$(window).height()+$(window).scrollTop();
        var elW= container.attr("containment")?container.parents().width():$(window).width()+$(window).scrollLeft();

        var elPos= container.attr("containment")? container.position():container.offset();
        $(container).resizable('option', 'maxHeight',elH-(elPos.top+20));
        $(container).resizable('option', 'maxWidth',elW-(elPos.left+20));
        o.helper.mb_bringToFront();
      },
      stop:function(){
        var resCont= $(this);//$.browser.msie || Opera ?o.helper:
        var elHeight= resCont.outerHeight()-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight());
        container.find(".c:first , .mbcontainercontent:first").css({height: elHeight});
        if (!isDraggable && !container.attr("handles")){
          var elWidth=container.attr("width") && container.attr("width")>0 ?container.attr("width"):"99.9%";
          container.css({width: elWidth});
        }
        var opt=container.attr("options");
        if(opt.onResize) opt.onResize(container);
        if (container.attr("rememberMe")){
          container.mb_setCookie("width",container.outerWidth());
          container.mb_setCookie("height",container.outerHeight());
        }
        container.setContainment();
      }
    });
    if (container.attr("resizeGrid") || (container.attr("resizeGridx") && container.attr("resizeGridy"))){
      var grid= container.attr("resizeGrid")? [container.attr("resizeGrid"),container.attr("resizeGrid")]:[container.attr("resizeGridx"),container.attr("resizeGridy")];
      container.resizable( "option", "grid", grid);
    }

    container.resizable('option', 'maxHeight', $("document").outerHeight()-(container.offset().top+container.outerHeight())-10);

    /*
     *TO SOLVE UI CSS CONFLICT I REDEFINED A SPECIFIC CLASS FOR HANDLERS
     */

    container.find(".ui-resizable-n").addClass("mb-resize").addClass("mb-resize-resizable-n");
    container.find(".ui-resizable-e").addClass("mb-resize").addClass("mb-resize-resizable-e");
    container.find(".ui-resizable-w").addClass("mb-resize").addClass("mb-resize-resizable-w");
    container.find(".ui-resizable-s").addClass("mb-resize").addClass("mb-resize-resizable-s");
    container.find(".ui-resizable-se").addClass("mb-resize").addClass("mb-resize-resizable-se");

  };

  jQuery.fn.containerSetIcon = function (icon,path){
    var container=$(this);
    if (icon && icon!="" ){
      container.find(".ne:first").prepend("<img class='icon' src='"+path+"icons/"+icon+"' style='position:absolute'/>");
      container.find(".n:first").css({paddingLeft:25});
    }else{
      container.find(".n:first").css({paddingLeft:0});
    }
  };

  jQuery.fn.containerSetButtons = function (buttons,opt){
    var container=$(this);
    if (!opt) opt=container.attr("options");
    var path= opt.elementsPath;
    if (buttons !=""){
      var btn=buttons.split(",");
      container.find(".ne:first").append("<div class='buttonBar'></div>");
      for (var i in btn){
        if (btn[i]=="c"){
          container.find(".buttonBar:first").append("<img src='"+path+container.attr('skin')+"/close.png' class='close'/>");
          container.find(".close:first").bind("click",function(){
            container.mb_close();
          });
        }
        if (btn[i]=="m"){
          container.find(".buttonBar:first").append("<img src='"+path+container.attr('skin')+"/min.png' class='collapsedContainer'/>");
          container.find(".collapsedContainer:first").bind("click",function(){container.containerCollapse(opt);});
          container.find(".n:first").bind("dblclick",function(){container.containerCollapse(opt);});
        }
        //todo : introduce print container content
        if (btn[i]=="p"){
          container.find(".buttonBar:first").append("<img src='"+path+container.attr('skin')+"/print.png' class='printContainer'/>");
          container.find(".printContainer:first").bind("click",function(){});
        }
        if (btn[i]=="i"){
          container.find(".buttonBar:first").append("<img src='"+path+container.attr('skin')+"/iconize.png' class='iconizeContainer'/>");
          container.find(".iconizeContainer:first").bind("click",function(){container.containerIconize(opt);});
        }
      }
      var fadeOnClose=$.browser.mozilla || $.browser.safari;
      if (fadeOnClose) container.find(".buttonBar:first img")
              .css({opacity:.5, cursor:"pointer","mozUserSelect": "none", "khtmlUserSelect": "none"})
              .mouseover(function(){$(this).fadeTo(200,1);})
              .mouseout(function(){if (fadeOnClose)$(this).fadeTo(200,.5);});
      container.find(".buttonBar:first img").attr("unselectable","on");
    }
  };

  jQuery.fn.containerCollapse = function (opt){
    this.each (function () {
      var container=$(this);
      if (!opt) opt=container.attr("options");
      if (!container.mb_getState("collapsed")){
        container.attr("w" , container.outerWidth());
        container.attr("h" , container.outerHeight());
        if (opt.collapseEffect=="fade")
          container.find(".o:first").fadeOut(opt.effectDuration,function(){});
        else{
          container.find(".icon:first").hide();
          container.find(".o:first").slideUp(opt.effectDuration,function(){});
          container.animate({height:container.find(".n:first").outerHeight()+container.find(".s:first").outerHeight()},opt.effectDuration,function(){container.find(".icon:first").show();});
        }
        container.attr("collapsed","true");
        container.find(".collapsedContainer:first").attr("src",opt.elementsPath+container.attr('skin')+"/max.png");
        container.resizable("disable");
        if (opt.onCollapse) opt.onCollapse(container);

      }else{
        if (opt.collapseEffect=="fade")
          container.find(".o:first").fadeIn(opt.effectDuration,function(){});
        else{
          container.find(".o:first").slideDown(opt.effectDuration,function(){});
          container.find(".icon:first").hide();
          container.animate({
            height:container.attr("h")
          },
                  opt.effectDuration,function(){
            container.find(".icon:first").show();
            container.css({height:""});
          });
        }
        if (container.hasClass("resizable")) container.resizable("enable");
        container.attr("collapsed","false");
        container.find(".collapsedContainer:first").attr("src",opt.elementsPath+container.attr('skin')+"/min.png");
        container.find(".mbcontainercontent:first").css("overflow","auto");
      }
      if (container.attr("rememberMe")) container.mb_setCookie("collapsed",container.mb_getState("collapsed"));
    });
  };

  jQuery.fn.containerIconize = function (opt,runCallback){
    var container=$(this);
    if (typeof runCallback=="undefined") runCallback=true;
    if (!opt) opt=container.attr("options");
    return this.each (function (){
      if (opt.onBeforeIconize) opt.onBeforeIconize(container);
      container.attr("iconized","true");
      if(container.attr("collapsed")=="false"){
        container.attr("h",container.outerHeight());
        container.attr("h",!container.attr("height") && !container.css("height")?"": container.outerHeight() );
      }
      container.attr("w",container.attr("width") && container.attr("width")>0 ? (!container.hasClass("resizable")? container.attr("width"):container.width()):!container.attr("handles")?"99.9%":container.width());
      container.attr("t",container.css("top"));
      container.attr("l",container.css("left"));
      container.resizable("disable");
      var l=0;
      var t= container.css("top");
      var dockPlace= container;
      if (container.attr("dock")){
        dockPlace = $("#"+container.attr("dock"));
        var icns= dockPlace.find("img:visible").size();
        l=$("#"+container.attr("dock")).offset().left+(opt.dockedIconDim*icns);
        t=$("#"+container.attr("dock")).offset().top+(opt.dockedIconDim/2);
      }
      /*
       ICONIZING CONTAINER
       */
      this.dockIcon= $("<img src='"+opt.elementsPath+"icons/"+(container.attr("icon")?container.attr("icon"):"restore.png")+"' class='restoreContainer' width='"+opt.dockedIconDim+"'/>").appendTo(dockPlace)
              .css("cursor","pointer")
              .hide()
              .attr("contTitle",container.find(".n:first").text())
              .bind("click",function(){

        container.attr("iconized","false");
        if (container.is(".draggable"))
          container.css({top:$(this).offset().top, left:$(this).offset().left});
        else
          container.css({left:"auto",top:"auto"});
        container.show();

        if (!$.browser.msie) {
          container.find(".no:first").fadeIn("fast");
          if(container.attr("collapsed")=="false"){
            container.animate({
              height:container.attr("h"),
              width:container.attr("w"),
              left:container.attr("l"),
              top:container.attr("t")},
                    opt.effectDuration,function(){
              container.find(".mbcontainercontent:first").css("overflow","auto");
              if(container.hasClass("draggable")) {
                container.mb_bringToFront(opt.zIndexContext);
              }
              container.css({height:""});
            });
          }else
            container.animate({height:"60px", width:container.attr("w"), left:container.attr("l"),top:container.attr("t")},opt.effectDuration);
        } else {
          container.find(".no:first").show();
          if(container.attr("collapsed")=="false"){
            container.css({height:container.attr("h"), width:container.attr("w"),left:container.attr("l"),top:container.attr("t")},opt.effectDuration);
            container.find(".c:first , .mbcontainercontent:first").css("height",container.attr("h")-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight()));
          }
          else
            container.css({height:"60px", width:container.attr("w"),left:container.attr("l"),top:container.attr("t")},opt.effectDuration);
        }
        if (container.hasClass("resizable") && container.attr("collapsed")=="false") container.resizable("enable");
        $(this).remove();
        if(container.hasClass("draggable")) container.mb_bringToFront(opt.zIndexContext);
        $(".iconLabel").remove();
        container.attr("restored", true);
        if(opt.onRestore) opt.onRestore(container);
        if (container.attr("rememberMe")){
          container.mb_setCookie("restored",container.mb_getState("restored"));
          container.mb_setCookie("closed", false);
          container.mb_setCookie("iconized", false);
          container.mb_setCookie("collapsed", false);
        }
        if (opt.mantainOnWindow) $.doOnWindowResize(container);
      })
              .bind("mouseenter",function(){
        var label="<div class='iconLabel'>"+$(this).attr("contTitle")+"</div>";
        $("body").append(label);
        $(".iconLabel").hide().css({
          position:"absolute",
          top:$(this).offset().top-20,
          left:$(this).offset().left+15,
          opacity:.9
        }).fadeIn("slow").mb_bringToFront(opt.zIndexContext);
      })
              .bind("mouseleave",function(){
        $(".iconLabel").fadeOut("fast",function(){$(this).remove();});
      });

      if (!$.browser.msie) {
        container.find(".mbcontainercontent:first").css("overflow","hidden");
        container.find(".no:first").slideUp("fast");
        container.animate({ height:opt.dockedIconDim, width:opt.dockedIconDim,left:l,top:t},opt.effectDuration,function(){
          $(this.dockIcon).show();
          if (container.attr("dock")) container.hide();
          if (opt.onIconize && runCallback) opt.onIconize(container);
        });
      }else{
        container.find(".no:first").hide();
        container.css({ height:opt.dockedIconDim, width:opt.dockedIconDim,left:l,top:t});
        $(this.dockIcon).show();
        if (container.attr("dock")) container.hide();
        if (opt.onIconize && runCallback) opt.onIconize(container);
      }
      if (container.attr("rememberMe")) container.mb_setCookie("iconized",container.mb_getState("iconized"));
    });
  };

  jQuery.fn.mb_resizeTo = function (h,w,anim){
    if (anim || anim==undefined) anim=200;
    else
      anim=0;
    var container=$(this);
    if(container.mb_getState('closed') || container.mb_getState('iconized') ){
      if (w) container.attr("w",w);
      if (h) container.attr("h",h);
      if (container.attr("rememberMe")){
        container.mb_setCookie("width",container.attr("w"));
        container.mb_setCookie("height",container.attr("h"));
      }
      return;
    }
    if (!w) w=container.outerWidth();
    if (!h) h=container.outerHeight();
    var elHeight= h-container.find(".n:first").outerHeight()-(container.find(".s:first").outerHeight());
    container.find(".c:first , .mbcontainercontent:first").animate({height: elHeight},anim);
    container.animate({"height":h,"width":w},anim,function(){
      container.adjastPos();
      var opt=container.attr("options");
      if (opt.onResize) opt.onResize(container);
      if (container.attr("rememberMe")){
        container.mb_setCookie("width",container.outerWidth());
        container.mb_setCookie("height",container.outerHeight());
      }
    });
  };

  jQuery.fn.mb_iconize = function (){
    return this.each(function(){
      var container=$(this);
      var opt= container.get(0).options;
      var el=container.get(0);
      if (!container.mb_getState('closed')){
        if (container.mb_getState('iconized')){
          var icon=el.dockIcon;
          $(icon).click();
          container.mb_bringToFront(opt.zIndexContext);
        }else{
          container.containerIconize();
        }
      }
    });
  };

  jQuery.fn.mb_open = function (url,data){
    this.each(function(){
      var container=$(this);
      if (container.mb_getState('closed')){
        var opt= container.get(0).options;
        var t=Math.floor(container.attr("t"));
        var l=Math.floor(container.attr("l"));
        container.css({top:t+"px", left:l+"px"});
        var el=container.get(0);
        if (url){
          if (!data) data="";
          container.mb_changeContainerContent(url,data);
        }

        if (!$.browser.msie){
          container.css("opacity",0);
          container.css("visibility","visible");
          container.fadeTo(opt.effectDuration*2,1);
        } else {
          container.css("visibility","visible");
          container.show();
        }

        container.attr("closed","false");
        if (container.attr("rememberMe")){
          container.mb_setCookie("closed",false);
          container.mb_setCookie("restored",true);
        }

        container.mb_bringToFront(opt.zIndexContext);
        container.attr("restored", true);

        if(!container.mb_getState("collapsed")){
          container.mb_resizeTo(container.attr("h"),container.attr("w"),false);
        }
        if(el.options.onRestore) el.options.onRestore($(el));
      }
      return container;
    })
  };

  jQuery.fn.mb_close = function (){
    var el=$(this).get(0);
    var container=$(this);
    if (!container.mb_getState('closed') && !container.mb_getState('iconized')){
      if(el.options.onBeforeClose) el.options.onBeforeClose($(el));
      if(!container.mb_getState('collapsed')){
        container.attr("w",container.outerWidth());
        container.attr("h",container.outerHeight());
        container.attr("t",container.offset().top);
        container.attr("l",container.offset().left);
      }
      if (container.attr("rememberMe")) container.mb_setCookie("closed",true);
      if (!$.browser.msie)
        container.fadeOut(300,function(){if(el.options.onClose) el.options.onClose($(el));});
      else {
        container.hide();
        if(el.options.onClose) el.options.onClose($(el));
      }
      container.attr("closed","true");
    }
    return $(this);
  };

  jQuery.fn.mb_toggle = function (){
    if (!$(this).mb_getState('closed') && !$(this).mb_getState('iconized')){
      $(this).containerCollapse();
    }
    return $(this);
  };

  jQuery.fn.mb_changeContent= function(url, data){
    var where=$(this);
    if (!data) data="";
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      success: function(html){
        where.html(html);
      }
    });
  };

  jQuery.fn.mb_expand=function(path){
    if($(this).mb_getState('closed'))
      $(this).mb_open();
    if(!$(this).mb_getState('iconized')) return;
    if(path)
      $(this).mb_changeContainerContent(path);

    $(this).mb_iconize();
  };


  jQuery.fn.mb_changeContainerContent=function(url, data){
    $(this).find(".mbcontainercontent:first").mb_changeContent(url,data);
  };

  jQuery.fn.mb_getState= function(attr){
    var state = $(this).attr(attr);
    state= state == "true";
    return state;
  };

  jQuery.fn.mb_fullscreen= function(){
    var container=$(this);
    var opt= container.get(0).options;
    if (container.mb_getState('iconized') || container.mb_getState('collapsed') || container.mb_getState('closed')){
      container.attr("w",$(window).width()-40);
      container.attr("h",$(window).height()-40);
      container.attr("t",20);
      container.attr("l",20);
      container.css("height","");
      return;
    }
    container.animate({top:20,left:20, position:"relative"},200, function(){
      if (container.attr("rememberMe")){
        container.mb_setCookie("x",$(this).css("left"));
        container.mb_setCookie("y",$(this).css("top"));
      }
    });
    container.mb_resizeTo($(window).height()-40,$(window).width()-40);

    container.attr("w",$(this).outerWidth());
    container.attr("h",$(this).outerHeight());
    container.attr("t",$(this).offset().top);
    container.attr("l",$(this).offset().left);
    container.css("height","");
    container.mb_bringToFront(opt.zIndexContext);
    return container;
  };

  jQuery.fn.mb_centerOnWindow=function(anim){
    var container=$(this);
    var nww=$(window).width();
    var nwh=$(window).height();
    var ow=container.outerWidth();
    var oh= container.outerHeight();
    var l= (nww-ow)/2;
    var t= ((nwh-oh)/2)>0?(nwh-oh)/2:10;
    if (container.css("position")!="fixed"){
      l=l+$(window).scrollLeft();
      t=t+$(window).scrollTop();
    }
    if (anim)
      container.animate({top:t,left:l},300,function(){
        if (container.attr("rememberMe")){
          container.mb_setCookie("x",$(this).css("left"));
          container.mb_setCookie("y",$(this).css("top"));
        }
      });
    else{
      container.css({top:t,left:l});
      if (container.attr("rememberMe")){
        container.mb_setCookie("x",$(this).css("left"));
        container.mb_setCookie("y",$(this).css("top"));
      }
    }
    return container;
  };

  jQuery.fn.mb_switchFixedPosition=function(){
    return this.each(function(){
      var container=$(this);
      if(typeof container.attr("pos") == "undefined")
        container.attr("pos", container.css("position"));
      if(container.css("position") == container.attr("pos")){
        container.css("top", parseFloat(container.css("top"))-$(window).scrollTop());
        container.css("position","fixed");
      } else{
        container.css("position",container.attr("pos"));
        container.css("top", parseFloat(container.css("top"))+$(window).scrollTop());
      }
    });
  };
  jQuery.fn.mb_switchAlwaisOnTop=function(){
    return this.each(function(){
      var container=$(this);
      if (!container.hasClass("alwaysOnTop")){
        container.get(0).zi=container.css("z-index");
        container.css("z-index",100000).addClass("alwaysOnTop");
      }else{
        container.removeClass("alwaysOnTop").css("z-index",container.get(0).zi);
      }
    });
  };

  jQuery.fn.mb_setPosition=function(top,left){
    return this.each(function(){
      var container=$(this);
      container.animate({top:top, left:left},300);
    });
  };

  jQuery.fn.mb_bringToFront= function(zIndexContext){
    var zi=10;
    var els= zIndexContext && zIndexContext!="auto" ? $(zIndexContext):$("*");
    els.not(".alwaysOnTop").each(function() {
      if($(this).css("position")=="absolute" || $(this).css("position")=="fixed"){
        var cur = parseInt($(this).css('zIndex'));
        zi = cur > zi ? parseInt($(this).css('zIndex')) : zi;
      }
    });
    $(this).not(".alwaysOnTop").css('zIndex',zi+=1);
    return zi;
  };

  //MANAGE WINDOWS POSITION ONRESIZE
  var winw=$(window).width();
  var winh=$(window).height();
  $.doOnWindowResize=function(el){
    clearTimeout(el.doRes);
    el.doRes=setTimeout(function(){
      $(el).adjastPos();
      winw=$(window).width();	winh=$(window).height();
    },400);
  };

  $.fn.adjastPos= function(margin){
    var container=$(this);
    var opt=container.attr("options");
    if (!opt.mantainOnWindow) return;
    if(!margin) margin=20;
    var nww=$(window).width()+$(window).scrollLeft();
    var nwh=$(window).height()+$(window).scrollTop();
    this.each(function(){
      var left=container.offset().left, top=container.offset().top;
      if ((left+container.outerWidth())>nww || top+container.outerHeight()>nwh || left<0 || top<0){
        var l=(container.offset().left+container.outerWidth())>nww ? nww-container.outerWidth()-margin: container.offset().left<0? margin: container.offset().left;
        var t= (container.offset().top+container.outerHeight())>nwh ? nwh-container.outerHeight()-margin: container.offset().top<0 ?margin: container.offset().top;
        container.animate({left:l, top:t},550,function(){
          container.setContainment();
        });
      }
      container.setContainment();
    });
  };

  //COOKIES
  jQuery.fn.mb_setCookie = function(name,value,days) {
    var id=$(this).attr("id");
    if(!id) id="";
    if (!days) days=7;
    var date = new Date(), expires;
    date.setTime(date.getTime()+(days*24*60*60*1000));
    expires = "; expires="+date.toGMTString();
    document.cookie = name+"_"+id+"="+value+expires+"; path=/";
  };

  jQuery.fn.mb_getCookie = function(name) {
    var id=$(this).attr("id");
    if(!id) id="";
    var nameEQ = name+"_"+id + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  };

  jQuery.fn.mb_removeCookie = function(name) {
    $(this).mb_setCookie(name,"",-1);
  };

})(jQuery);

/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2010. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: mbicocchi@open-lab.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/**
 * Sets the type of metadata to use. Metadata is encoded in JSON, and each property
 * in the JSON will become a property of the element itself.
 *
 * There are three supported types of metadata storage:
 *
 *   attr:  Inside an attribute. The name parameter indicates *which* attribute.
 *          
 *   class: Inside the class attribute, wrapped in curly braces: { }
 *   
 *   elem:  Inside a child element (e.g. a script tag). The
 *          name parameter indicates *which* element.
 *          
 * The metadata for an element is loaded the first time the element is accessed via jQuery.
 *
 * As a result, you can define the metadata type, use $(expr) to load the metadata into the elements
 * matched by expr, then redefine the metadata type and run another $(expr) for other elements.
 * 
 * @name $.metadata.setType
 *
 * @example <p id="one" class="some_class {item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metadata.setType("class")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from the class attribute
 * 
 * @example <p id="one" class="some_class" data="{item_id: 1, item_label: 'Label'}">This is a p</p>
 * @before $.metadata.setType("attr", "data")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from a "data" attribute
 * 
 * @example <p id="one" class="some_class"><script>{item_id: 1, item_label: 'Label'}</script>This is a p</p>
 * @before $.metadata.setType("elem", "script")
 * @after $("#one").metadata().item_id == 1; $("#one").metadata().item_label == "Label"
 * @desc Reads metadata from a nested script element
 * 
 * @param String type The encoding type
 * @param String name The name of the attribute to be used to get metadata (optional)
 * @cat Plugins/Metadata
 * @descr Sets the type of encoding to be used when loading metadata for the first time
 * @type undefined
 * @see metadata()
 */

(function($) {

$.extend({
	metadata : {
		defaults : {
			type: 'class',
			name: 'metadata',
			cre: /({.*})/,
			single: 'metadata'
		},
		setType: function( type, name ){
			this.defaults.type = type;
			this.defaults.name = name;
		},
		get: function( elem, opts ){
			var settings = $.extend({},this.defaults,opts);
			// check for empty string in single property
			if ( !settings.single.length ) settings.single = 'metadata';
			
			var data = $.data(elem, settings.single);
			// returned cached data if it already exists
			if ( data ) return data;
			
			data = "{}";
			
			if ( settings.type == "class" ) {
				var m = settings.cre.exec( elem.className );
				if ( m )
					data = m[1];
			} else if ( settings.type == "elem" ) {
				if( !elem.getElementsByTagName )
					return undefined;
				var e = elem.getElementsByTagName(settings.name);
				if ( e.length )
					data = $.trim(e[0].innerHTML);
			} else if ( elem.getAttribute != undefined ) {
				var attr = elem.getAttribute( settings.name );
				if ( attr )
					data = attr;
			}
			
			if ( data.indexOf( '{' ) <0 )
			data = "{" + data + "}";
			
			data = eval("(" + data + ")");
			
			$.data( elem, settings.single, data );
			return data;
		}
	}
});

/**
 * Returns the metadata object for the first member of the jQuery object.
 *
 * @name metadata
 * @descr Returns element's metadata object
 * @param Object opts An object contianing settings to override the defaults
 * @type jQuery
 * @cat Plugins/Metadata
 */
$.fn.metadata = function( opts ){
	return $.metadata.get( this[0], opts );
};

})(jQuery);