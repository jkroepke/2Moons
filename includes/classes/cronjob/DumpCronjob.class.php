
<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class DumpCronjob
{
	function run()
	{
		$prefixCounts	= strlen(DB_PREFIX);
		$dbTables		= array();
		$sqlTableRaw	= $GLOBALS['DATABASE']->query("SHOW TABLE STATUS FROM `".DB_NAME."`;");

		while($table = $GLOBALS['DATABASE']->fetchArray($sqlTableRaw))
		{
			if(DB_PREFIX == substr($table['Name'], 0, $prefixCounts))
			{
				$dbTables[]	= $table['Name'];
			}
		}
		
		if(empty($dbTables))
		{
			throw new Exception('No tables found for dump.');
		}
		
		$fileName	= '2MoonsBackup_'.date('d_m_Y_H_i_s', TIMESTAMP).'.sql';
		$filePath	= 'includes/backups/'.$fileName;
		
		require 'includes/classes/SQLDumper.class.php';
		
		$dump	= new SQLDumper;
		$dump->dumpTablesToFile($dbTables, $filePath);
	}
}