<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
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
			$filePath	= 'includes/backups/'.$fileName;
		
			require 'includes/classes/SQLDumper.class.php';
		
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