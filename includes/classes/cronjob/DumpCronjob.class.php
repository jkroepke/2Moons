
<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class DumpCronjob implements CronjobTask
{
	function run()
	{
		$prefixCounts	= strlen(DB_PREFIX);
		$dbTables		= array();
		$tableNames		= Database::get()->nativeQuery('SHOW TABLE STATUS FROM '.DB_NAME.';');

		foreach($tableNames as $table)
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