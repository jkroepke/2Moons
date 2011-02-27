(function($){var textarea;var options;var disable_buttons=new Object();var store_event;var store_data=new Array('');var undo_pos=0;var ie_cache=null;var ie_btn=null;var lb='\n';var pause=false;$.fn.bbcodeeditor=function(opt)
{options=$.extend({},$.fn.bbcodeeditor.defaults,opt);textarea=this;if(!$.browser.opera)textarea.keydown(key_handler);else textarea.keypress(key_handler);if($.browser.msie){$(document).mousedown(function(e){if(ie_btn!=null&&ie_btn==textarea[0])ie_cache=document.selection.createRange();ie_btn=e.target;});}
if($.browser.msie||$.browser.opera)lb='\r\n';if(options.bold!=false)options.bold.click(function(){print_bbc('bold text','[b]','[/b]')});if(options.italic!=false)options.italic.click(function(){print_bbc('italic text','[i]','[/i]')});if(options.underline!=false)options.underline.click(function(){print_bbc('underline text','[u]','[/u]')});if(options.link!=false)options.link.click(add_link);if(options.quote!=false)options.quote.click(function(){print_bbc('quote','[quote]','[/quote]',true)});if(options.code!=false)options.code.click(function(){print_bbc('function(event) {','[code]','[/code]',true)});if(options.image!=false)options.image.click(add_image);if(options.nlist!=false)options.nlist.click(function(){print_bbc('list item','[list=1]'+lb+'[*]','[/list]',true)});if(options.blist!=false)options.blist.click(function(){print_bbc('list item','[list]'+lb+'[*]','[/list]',true)});if(options.litem!=false)options.litem.click(function(){print_bbc('list item','[*]','',true)});if(options.usize!=false)options.usize.click(function(){font_size(true)});if(options.dsize!=false)options.dsize.click(function(){font_size(false)});if(options.back!=false)
{if(options.back_disable!=false)disable_buttons.back=options.back[0].className;options.back.click(go_back);enable_back(false);}
if(options.forward!=false)
{if(options.forward_disable!=false)disable_buttons.forward=options.forward[0].className;options.forward.click(go_forward);enable_forward(false);}
if(options.back!=false||options.forward!=false)textarea.keyup(backup_handler);$.fn.bbcodeeditor.preview();return this;};function enable_back(bool)
{if(!bool)
{if(options.back_disable==false)
{options.back.css('opacity',0.5);}
else if(options.back!=false)
{options.back[0].className=options.back_disable;}}
else
{if(options.back_disable==false)
{options.back.css('opacity',1);}
else if(options.back!=false)
{options.back[0].className=disable_buttons.back;}}}
function enable_forward(bool)
{if(!bool)
{if(options.forward_disable==false)
{options.forward.css('opacity',0.5);}
else if(options.forward!=false)
{options.forward[0].className=options.forward_disable;}}
else
{if(options.forward_disable==false)
{options.forward.css('opacity',1);}
else if(options.forward!=false)
{options.forward[0].className=disable_buttons.forward;}}}
function exit_page(e)
{if(options.exit_warning&&!pause&&textarea[0].value!="")
{var e=e||window.event;if(e)
{e.returnValue='You have started writing a post.';}
return'You have started writing a post.';}}
function backup_handler(e)
{if($.browser.msie)ie_cache=document.selection.createRange();if(e.keyCode!=17&&!(e.ctrlKey&&(e.keyCode==89||e.keyCode==90)))
{if(textarea.val().length!=0)enable_back(true);else enable_back(false);if(undo_pos!=0)
{store_data.slice(0,store_data.length-undo_pos);enable_forward(false);undo_pos=0;}
if(e.keyCode==8||e.keyCode==13||e.keyCode==32||e.keyCode==46||(e.ctrlKey&&(e.keyCode==67||e.keyCode==86)))backup();$.fn.bbcodeeditor.preview();}}
function key_handler(e)
{if($.browser.msie)ie_cache=document.selection.createRange();if(options.keyboard&&e.ctrlKey)
{if(e.keyCode==66&&options.bold!=false)
{e.preventDefault();print_bbc('bold text','[b]','[/b]');}
else if(e.keyCode==73&&options.italic!=false)
{e.preventDefault();print_bbc('italic text','[i]','[/i]');}
else if(e.keyCode==75&&options.code!=false)
{e.preventDefault();print_bbc('function(event) {','[code]','[/code]',true);}
else if(e.keyCode==76&&options.link!=false)
{e.preventDefault();add_link();}
else if(e.keyCode==80&&options.image!=false)
{e.preventDefault();add_image();}
else if(e.keyCode==81&&options.quote!=false)
{e.preventDefault();print_bbc('quote','[quote]','[/quote]',true);}
else if(e.keyCode==85&&options.underline!=false)
{e.preventDefault();print_bbc('underline text','[u]','[/u]');}
else if(e.keyCode==89&&options.forward!=false)
{e.preventDefault();go_forward();}
else if(e.keyCode==90&&options.back!=false)
{e.preventDefault();go_back();}}
if(e.keyCode==13){var start=selection_range().start;var line=textarea[0].value.substring(0,start).lastIndexOf('\n');line=(line==-1?0:line+1);var matches=textarea[0].value.substring(line,start).match(/^\t+/g);if(matches!=null)
{e.preventDefault();var scroll_fix=fix_scroll_pre();var tabs=lb;for(var i=0;i<matches[0].length;i++)tabs+='\t';textarea[0].value=textarea[0].value.substring(0,start)+tabs+textarea[0].value.substring(start);set_focus(start+tabs.length,start+tabs.length);fix_scroll(scroll_fix);}}
else if(e.keyCode==9)
{e.preventDefault();var scroll_fix=fix_scroll_pre();backup();var range=selection_range();if(range.start!=range.end&&textarea[0].value.substr(range.start,1)=='\n')range.start++;var matches=textarea[0].value.substring(range.start,range.end).match(/\n/g);if(matches!=null)
{var index=textarea[0].value.substring(0,range.start).lastIndexOf(lb);var start_tab=(index!=-1?index:0);if(!e.shiftKey)
{var tab=textarea[0].value.substring(start_tab,range.end).replace(/\n/g,'\n\t');textarea[0].value=(index==-1?'\t':'')+textarea[0].value.substring(0,start_tab)+tab+textarea[0].value.substring(range.end);set_focus(range.start+1,range.end+matches.length+1);}
else
{var i=(textarea[0].value.substr((index!=-1?index+lb.length:0),1)=='\t'?1:0);var removed=textarea[0].value.substring(start_tab,range.end).match(/\n\t/g,'\n');if(index==-1&&textarea[0].value.substr(0,1)=='\t')
{textarea[0].value=textarea[0].value.substr(1);removed.push(0);}
var tab=textarea[0].value.substring(start_tab,range.end).replace(/\n\t/g,'\n');textarea[0].value=textarea[0].value.substring(0,start_tab)+tab+textarea[0].value.substring(range.end);set_focus(range.start-i,range.end-(removed!=null?removed.length:0));}}
else
{if(!e.shiftKey)
{textarea[0].value=textarea[0].value.substring(0,range.start)+'\t'+textarea[0].value.substring(range.start);set_focus(range.start+1,range.start+1);}
else
{var i_o=textarea[0].value.substring(0,range.start).lastIndexOf('\n');var i_s=(i_o==-1?0:i_o);var i_e=textarea[0].value.substring(i_s+1).indexOf('\n');if(i_e==-1)i_e=textarea[0].value.length;else i_e+=i_s+1;if(i_o==-1)
{var match=textarea[0].value.substring(i_s,i_e).match(/^\t/);var tab=textarea[0].value.substring(i_s,i_e).replace(/^\t/,'');}
else
{var match=textarea[0].value.substring(i_s,i_e).match(/\n\t/);var tab=textarea[0].value.substring(i_s,i_e).replace(/\n\t/,'\n');}
textarea[0].value=textarea[0].value.substring(0,i_s)+tab+textarea[0].value.substring(i_e);if(match!=null)set_focus(range.start-(range.start-1>i_o?1:0),range.end-((range.start-1>i_o||range.start!=range.end)?1:0));}}
fix_scroll(scroll_fix);}}
function fix_scroll_pre()
{return{scrollTop:textarea.scrollTop(),scrollHeight:textarea[0].scrollHeight}}
function fix_scroll(obj)
{textarea.scrollTop(obj.scrollTop+textarea[0].scrollHeight-obj.scrollHeight);}
function backup()
{undo_pos=0;enable_forward(false);enable_back(true);if(store_data[store_data.length-1]!=textarea[0].value)store_data.push(textarea[0].value);}
function go_back()
{var scrollTop=textarea.scrollTop();if(undo_pos==0)
{backup();undo_pos++;}
if(undo_pos!=store_data.length)
{undo_pos++;textarea[0].value=store_data[store_data.length-undo_pos];$.fn.bbcodeeditor.preview();enable_forward(true);if(undo_pos==store_data.length)enable_back(false);}
textarea.scrollTop(scrollTop);};function go_forward()
{var scrollTop=textarea.scrollTop();if(undo_pos>1)
{textarea[0].value=store_data[store_data.length---undo_pos];$.fn.bbcodeeditor.preview();enable_back(true);if(undo_pos==1)enable_forward(false);}
textarea.scrollTop(scrollTop);};function print_bbc(txt,open,close,clean_line)
{backup();var range=selection_range();var scroll_fix=fix_scroll_pre();if(clean_line)
{if(close!='[/list]'&&open!='[*]')open=open+lb;if(open!='[*]')close=lb+close;if(range.start!=0&&textarea[0].value.substr(range.start-1,1)!=lb.substr(0,1))open=lb+open;if(textarea[0].value.length!=range.end&&textarea[0].value.substr(range.end,1)!=lb.substr(0,1))close=close+lb;}
if(range.start!=range.end)
{txt=textarea[0].value;if(clean_line)
{var re_b=new RegExp('\\['+close.substring((lb.length==2?4:3),close.length-1)+'(.*?)'+'\\]'+lb+(close==lb+'[/list]'?'\\[\\*\\]':'')+'$');var re_a=new RegExp('^'+lb+'\\[\/'+close.substring((lb.length==2?4:3),close.length-1)+'\\]');}
else
{var re_b=new RegExp('\\['+close.substring(2,close.length-1)+'([^\\]]*?)\\]$','g');var re_a=new RegExp('^\\[\/'+close.substring(2,close.length-1)+'\\]','g');}
var m_b=txt.substring(0,range.start).match(re_b);var m_a=txt.substring(range.end).match(re_a);if(m_b!=null&&m_a!=null)
{textarea[0].value=txt.substring(0,range.start).replace(re_b,'')+txt.substring(range.start,range.end)+txt.substring(range.end).replace(re_a,'');set_focus(range.start-m_b[0].length,range.end-m_b[0].length);}
else
{textarea[0].value=textarea[0].value.substr(0,range.start)+open+textarea[0].value.substring(range.start,range.end)+close+textarea[0].value.substr(range.end);set_focus(range.start+open.length,range.end+open.length);}}
else
{textarea[0].value=textarea[0].value.substring(0,range.start)+open+txt+close+textarea[0].value.substring(range.end);set_focus(range.start+open.length,range.start+open.length+txt.length);}
fix_scroll(scroll_fix);$.fn.bbcodeeditor.preview();};function set_focus(start,end)
{if(!$.browser.msie)
{textarea[0].setSelectionRange(start,end);textarea.focus();}
else
{var m_s=textarea[0].value.substring(0,start).match(/\r/g);m_s=(m_s!=null?m_s.length:0);var m_e=textarea[0].value.substring(start,end).match(/\r/g);m_e=(m_e!=null?m_e.length:0);var range=textarea[0].createTextRange();range.collapse(true);range.moveStart('character',start-m_s);range.moveEnd('character',end-start-m_e);range.select();ie_cache=document.selection.createRange();}};function font_size(increase)
{if(increase)print_bbc('text','[size=24]','[/size]');else print_bbc('text','[size=12]','[/size]');}
function add_image()
{var link='http://';print_bbc(link,'[img]','[/img]');};function add_link(image)
{var link="http://";print_bbc('link text','[url='+link+']','[/url]');};function selection_range()
{if(!$.browser.msie)
{return{start:textarea[0].selectionStart,end:textarea[0].selectionEnd}}
else
{if(ie_cache==null)return{start:textarea[0].value.length,end:textarea[0].value.length};var selection_range=ie_cache.duplicate();var before_range=document.body.createTextRange();before_range.moveToElementText(textarea[0]);before_range.setEndPoint("EndToStart",selection_range);var after_range=document.body.createTextRange();after_range.moveToElementText(textarea[0]);after_range.setEndPoint("StartToEnd",selection_range);var before_finished=false,selection_finished=false,after_finished=false;var before_text,untrimmed_before_text,selection_text,untrimmed_selection_text,after_text,untrimmed_after_text;before_text=untrimmed_before_text=before_range.text;selection_text=untrimmed_selection_text=selection_range.text;after_text=untrimmed_after_text=after_range.text;do{if(!before_finished){if(before_range.compareEndPoints("StartToEnd",before_range)==0){before_finished=true;}else{before_range.moveEnd("character",-1)
if(before_range.text==before_text){untrimmed_before_text+="\r\n";}else{before_finished=true;}}}
if(!selection_finished){if(selection_range.compareEndPoints("StartToEnd",selection_range)==0){selection_finished=true;}else{selection_range.moveEnd("character",-1)
if(selection_range.text==selection_text){untrimmed_selection_text+="\r\n";}else{selection_finished=true;}}}
if(!after_finished){if(after_range.compareEndPoints("StartToEnd",after_range)==0){after_finished=true;}else{after_range.moveEnd("character",-1)
if(after_range.text==after_text){untrimmed_after_text+="\r\n";}else{after_finished=true;}}}}while((!before_finished||!selection_finished||!after_finished));return{start:untrimmed_before_text.length,end:untrimmed_before_text.length+untrimmed_selection_text.length};}}
$.fn.bbcodeeditor.defaults={bold:false,italic:false,underline:false,link:false,quote:false,code:false,image:false,usize:false,nsize:false,nlist:false,blist:false,litem:false,back:false,back_disable:false,forward:false,forward_disable:false,exit_warning:false,preview:false,keyboard:true};$.fn.bbcodeeditor.preview=function(){if(options.preview!=false)
{var txt=textarea.val();txt=txt.replace(/</g,'&lt;');txt=txt.replace(/>/g,'&gt;');txt=txt.replace(/[\r\n]/g,'%lb%');var find=[/\[b\](.*?)\[\/b\]/gi,/\[i\](.*?)\[\/i\]/gi,/\[u\](.*?)\[\/u\]/gi,/\[size=(\d.\d?)](.*?)\[\/size\]/gi,/\[url(?:\=?)(.*?)\](.*?)\[\/url\]/gi,/\[img(.*?)\](.*?)\[\/img\]/gi,/(?:%lb%|\s)*\[code(?:\=?)(?:.*?)\](?:%lb%|\s)*(.*?)(?:%lb%|\s)*\[\/code\](?:%lb%|\s)*/gi,/(?:%lb%|\s)*\[quote(?:\=?)(.*?)\](?:%lb%|\s)*(.*?)(?:%lb%|\s)*\[\/quote\](?:%lb%|\s)*/gi,/\[list(.*?)\](.*?)\[\*\](.*?)(?:%lb%|\s)*(\[\*\].*?\[\/list\]|\[\/list\])/i,/(?:%lb%|\s)*\[list\](?:%lb%|\s)*(.*?)(?:%lb%|\s)*\[\/list\](?:%lb%|\s)*/gi,/(?:%lb%|\s)*\[list=(\d)\](?:%lb%|\s)*(.*?)(?:%lb%|\s)*\[\/list\](?:%lb%|\s)*/gi,/(?:%lb%){3,}/g,/\[bg=(.*?)\](.*?)\[\/bg\]/gi,/\[color=(.*?)\](.*?)\[\/color\]/gi,];var replace=['<b>$1<\/b>','<i>$1<\/i>','<u>$1<\/u>','<span style="font-size:$1px;">$2</span>','<a href="$1">$2</a>','<img $1 src="$2" />','<pre><code>$1</code></pre>','<blockquote>$2</blockquote>','[list$1]$2<li>$3</li>$4','<ul>$1</ul>','<ol start=$1>$2</ol>','%lb%%lb%','<div style="background: url(\'$1\');">$2</div>','<span style="color:\'$1\'">$2</span>',];for(var i in find)
{txt=txt.replace(find[i],replace[i]);if(i==8)while(txt.match(find[i],replace[i]))txt=txt.replace(find[i],replace[i]);}
txt=txt.replace(/%lb%/g,'<br />');options.preview.html(txt);}};$.fn.bbcodeeditor.pause=function(){if(!pause)pause=true;else pause=false;};})(jQuery);


$(function(){
	$('.bbcode').bbcodeeditor({
		bold:$('.bold'),italic:$('.italic'),underline:$('.underline'),link:$('.link'),quote:$('.quote'),code:$('.code'),image:$('.image'),
		usize:$('.usize'),dsize:$('.dsize'),blist:$('.blist'),litem:$('.litem'),
		back:$('.back'),forward:$('.forward'),back_disable:'btn back_disable',forward_disable:'btn forward_disable',
		exit_warning:true,preview:$('.preview')
	});
});