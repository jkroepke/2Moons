<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

class langtools
{
	function lang_getuserlang($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
        if ($lang_variable === null) {
                $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        if (empty($lang_variable)) {
                return $default_language;
        }

        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        $current_lang = $default_language;
        $current_q = 0;

        foreach ($accepted_languages as $accepted_language) {
            $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.'(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

            if (!$res) {
                continue;
            }
                
            $lang_code = explode ('-', $matches[1]);

            if (isset($matches[2])) {
                    $lang_quality = (float)$matches[2];
            } else {
                    $lang_quality = 1.0;
            }

            while (count ($lang_code)) {
                if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                    if ($lang_quality > $current_q) {
                        $current_lang = strtolower (join ('-', $lang_code));
                        $current_q = $lang_quality;
                        break;
                    }
                }
                if ($strict_mode) {
                    break;
                }
                array_pop ($lang_code);
            }
        }
		
        return $current_lang;
	}
}

?>