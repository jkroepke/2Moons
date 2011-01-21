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