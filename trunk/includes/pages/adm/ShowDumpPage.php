<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if ($USER['authlevel'] == AUTH_USR)
{
	throw new PagePermissionException("Permission error!");
}

function ShowDumpPage()
{
	global $LNG;
	switch($_REQUEST['action'])
	{
		case 'dump':
			$dbTables	= HTTP::_GP('dbtables', array());
			if(empty($dbTables)) {
				$template	= new template();
				$template->message($LNG['du_not_tables_selected']);
				exit;
			}
			
			$fileName	= '2MoonsBackup_'.date('d_m_Y_H_i_s', TIMESTAMP).'.sql';
			$filePath	= ROOT_PATH.'includes/backups/'.$fileName;
		
			require ROOT_PATH.'includes/classes/SQLDumper.class.php';
		
			$dump	= new SQLDumper;
			$dump->dumpTablesToFile($dbTables, $filePath);
			
			$template	= new template();
			$template->message(sprintf($LNG['du_success'], 'includes/backups/'.$fileName));
		break;
		default:
			$dumpData['perRequest']		= 100;

			$dumpData		= array();

			$prefixCounts	= strlen(DB_PREFIX);

			$dumpData['sqlTables']	= array();
			$sqlTableRaw			= $GLOBALS['DATABASE']->query("SHOW TABLE STATUS FROM `".DB_NAME."`;");

			while($table = $GLOBALS['DATABASE']->fetchArray($sqlTableRaw))
			{
				if(DB_PREFIX == substr($table['Name'], 0, $prefixCounts))
				{
					$dumpData['sqlTables'][]	= $table['Name'];
				}
			}

			$template	= new template();

			$template->assign_vars(array(	
				'dumpData'	=> $dumpData,
			));
			
			$template->show('DumpPage.tpl');
		break;
	}
}