/*==================================================*
 $Id: filterlist.js,v 1.3 2003/10/08 17:13:49 pat Exp $
 Copyright 2003 Patrick Fitzgerald
 http://www.barelyfitz.com/webdesign/articles/filterlist/

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *==================================================*/
function filterlist(selectobj){this.selectobj=selectobj;this.flags='i';this.match_text=true;this.match_value=false;this.show_debug=false;this.init=function(){if(!this.selectobj)return this.debug('selectobj not defined');if(!this.selectobj.options)return this.debug('selectobj.options not defined');this.optionscopy=new Array();if(this.selectobj&&this.selectobj.options){for(var i=0;i<this.selectobj.options.length;i++){this.optionscopy[i]=new Option();this.optionscopy[i].text=selectobj.options[i].text;if(selectobj.options[i].value){this.optionscopy[i].value=selectobj.options[i].value;}else{this.optionscopy[i].value=selectobj.options[i].text;}}}}
this.reset=function(){this.set('');}
this.set=function(pattern){var loop=0,index=0,regexp,e;if(!this.selectobj)return this.debug('selectobj not defined');if(!this.selectobj.options)return this.debug('selectobj.options not defined');this.selectobj.options.length=0;try{regexp=new RegExp(pattern,this.flags);}catch(e){if(typeof this.hook=='function'){this.hook();}
return;}
for(loop=0;loop<this.optionscopy.length;loop++){var option=this.optionscopy[loop];if((this.match_text&&regexp.test(option.text))||(this.match_value&&regexp.test(option.value))){this.selectobj.options[index++]=new Option(option.text,option.value,false);}}
if(typeof this.hook=='function'){this.hook();}}
this.set_ignore_case=function(value){if(value){this.flags='i';}else{this.flags='';}}
this.debug=function(msg){if(this.show_debug){alert('FilterList: '+msg);}}
this.init();}