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

class records
{
	public $File	= "cache/CacheRecords_Uni%d.php";
	
	function SetIfRecord($ID, $Count, $Data)
	{
		global $CONF;
		if(($CONF['stat'] == 1 && $Data['authlevel'] >= $CONF['stat_level']) || !empty($Data['bana']))
			return;
		
		if(!isset($this->maxinfos[$Data['universe']]))
			$this->maxinfos[$Data['universe']] = array();
			
		if(!isset($this->maxinfos[$Data['universe']][$ID]))
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => 0, 'username' => '');

		if($this->maxinfos[$Data['universe']][$ID]['maxlvl'] < $Count)
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => $Count, 'username' => $Data['username']);
	}

	function BuildRecordCache() 
	{
		$Elements	= array_merge($GLOBALS['reslist']['build'], $GLOBALS['reslist']['tech'], $GLOBALS['reslist']['fleet'], $GLOBALS['reslist']['defense']);
		foreach($this->maxinfos as $Uni	=> $Records) {
			$array		= "";
			foreach($Elements as $ElementID) {
				$array	.= $ElementID." => array('username' => '".(isset($Records[$ElementID]['username']) ? $Records[$ElementID]['username'] : '-')."', 'maxlvl' => '".(isset($Records[$ElementID]['maxlvl']) ? $Records[$ElementID]['maxlvl'] : '-')."'),\n";
			}
			$file	= "<?php \n//The File is created on ".date("d. M y H:i:s", TIMESTAMP)."\n$"."RecordsArray = array(\n".$array."\n);\n?>";
			file_put_contents(sprintf(ROOT_PATH.$this->File, $Uni), $file);
		}
	}
	
	function RenameRecordOwner($OldName, $NewName, $Uni)
	{
		$Content	= file_get_contents(sprintf(ROOT_PATH.$this->File, $Uni));	
		$Content	= str_replace("array('username' => '".$OldName."'", "array('username' => '".$NewName."'", $Content);	
		file_put_contents(sprintf(ROOT_PATH.$this->File, $Uni), $Content);	
	}
	
	function GetRecords($Uni)
	{
		if(!file_exists(sprintf(ROOT_PATH.$this->File, $Uni)))
			return array();
		
		require(sprintf(ROOT_PATH.$this->File, $Uni));
		return $RecordsArray;
	}
}

?>