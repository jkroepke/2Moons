/**
 * Copyright (c) 2009 Sergiy Kovalchuk (serg472@gmail.com)
 * 
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *  
 * Following code is based on Element.mask() implementation from ExtJS framework (http://extjs.com/)
 *
 */
(function(a){a.fn.mask=function(c){this.unmask();if(this.css("position")=="static"){this.addClass("masked-relative")}this.addClass("masked");var d=a('<div class="loadmask"></div>');if(navigator.userAgent.toLowerCase().indexOf("msie")>-1){d.height(this.height()+parseInt(this.css("padding-top"))+parseInt(this.css("padding-bottom")));d.width(this.width()+parseInt(this.css("padding-left"))+parseInt(this.css("padding-right")))}if(navigator.userAgent.toLowerCase().indexOf("msie 6")>-1){this.find("select").addClass("masked-hidden")}this.append(d);if(typeof c=="string"){var b=a('<div class="loadmask-msg" style="display:none;"></div>');b.append("<div>"+c+"</div>");this.append(b);b.css("top",Math.round(this.height()/2-(b.height()-parseInt(b.css("padding-top"))-parseInt(b.css("padding-bottom")))/2)+"px");b.css("left",Math.round(this.width()/2-(b.width()-parseInt(b.css("padding-left"))-parseInt(b.css("padding-right")))/2)+"px");b.show()}};a.fn.unmask=function(b){this.find(".loadmask-msg,.loadmask").remove();this.removeClass("masked");this.removeClass("masked-relative");this.find("select").removeClass("masked-hidden")}})(jQuery);