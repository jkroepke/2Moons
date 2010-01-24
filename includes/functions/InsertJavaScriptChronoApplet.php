<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

	function InsertJavaScriptChronoApplet ($Type, $Ref, $Value, $Init)
	{
		if ($Init == true)
		{
			$JavaString  = "<script type=\"text/javascript\">\n";
			$JavaString .= "function t". $Type . $Ref ."() {\n";
			$JavaString .= "v = new Date();\n";
			$JavaString .= "var bxx". $Type . $Ref ." = document.getElementById('bxx". $Type . $Ref ."');\n";
			$JavaString .= "n = new Date();\n";
			$JavaString .= "ss". $Type . $Ref ." = pp". $Type . $Ref .";\n";
			$JavaString .= "ss". $Type . $Ref ." = ss". $Type . $Ref ." - Math.round((n.getTime() - v.getTime()) / 1000.);\n";
			$JavaString .= "m". $Type . $Ref ." = 0;\n";
			$JavaString .= "h". $Type . $Ref ." = 0;\n";
			$JavaString .= "if (ss". $Type . $Ref ." < 0) {\n";
			$JavaString .= "	bxx". $Type . $Ref .".innerHTML = \"-\";\n";
			$JavaString .= "} else {\n";
			$JavaString .= "	if (ss". $Type . $Ref ." > 59) {\n";
			$JavaString .= "		m". $Type . $Ref ." = Math.floor(ss". $Type . $Ref ." / 60);\n";
			$JavaString .= "		ss". $Type . $Ref ." = ss". $Type . $Ref ." - m". $Type . $Ref ." * 60;\n";
			$JavaString .= "	}\n";
			$JavaString .= "	if (m". $Type . $Ref ." > 59) {\n";
			$JavaString .= "		h". $Type . $Ref ." = Math.floor(m". $Type . $Ref ." / 60);\n";
			$JavaString .= "		m". $Type . $Ref ." = m". $Type . $Ref ." - h". $Type . $Ref ." * 60;\n";
			$JavaString .= "	}\n";
			$JavaString .= "	if (ss". $Type . $Ref ." < 10) {\n";
			$JavaString .= "		ss". $Type . $Ref ." = \"0\" + ss". $Type . $Ref .";\n";
			$JavaString .= "	}\n";
			$JavaString .= "	if (m". $Type . $Ref ." < 10) {\n";
			$JavaString .= "		m". $Type . $Ref ." = \"0\" + m". $Type . $Ref .";\n";
			$JavaString .= "	}\n";
			$JavaString .= "	bxx". $Type . $Ref .".innerHTML = h". $Type . $Ref ." + \":\" + m". $Type . $Ref ." + \":\" + ss". $Type . $Ref .";\n";
			$JavaString .= "}\n";
			$JavaString .= "pp". $Type . $Ref ." = pp". $Type . $Ref ." - 1;\n";
			$JavaString .= "window.setTimeout(\"t". $Type . $Ref ."();\", 999);\n";
			$JavaString .= "}\n";
			$JavaString .= "</script>\n";
		}
		else
		{
			$JavaString  = "<script language=\"JavaScript\">\n";
			$JavaString .= "pp". $Type . $Ref ." = ". $Value .";\n";
			$JavaString .= "t". $Type . $Ref ."();\n";
			$JavaString .= "</script>\n";
		}

		return $JavaString;
	}
?>