<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

 
class ShowNotesPage extends AbstractGamePage
{
	public static $requireModule = MODULE_NOTICE;

	function __construct() 
	{
		parent::__construct();
		$this->setWindow('popup');
		$this->initTemplate();
	}
	
	function show()
	{
		global $LNG, $USER;

        $db = Database::get();

        $sql = "SELECT * FROM %%NOTES%% WHERE owner = :userID ORDER BY priority DESC, time DESC;";
        $notesResult = $db->select($sql, array(
            ':userID'   => $USER['id']
        ));

        $notesList		= array();
		
		foreach($notesResult as $notesRow)
		{
			$notesList[$notesRow['id']]	= array(
				'time'		=> _date($LNG['php_tdformat'], $notesRow['time'], $USER['timezone']),
				'title'		=> $notesRow['title'],
				'size'		=> strlen($notesRow['text']),
				'priority'	=> $notesRow['priority'],
			);
		}
		
		$this->assign(array(
			'notesList'	=> $notesList,
		));
		
		$this->display('page.notes.default.tpl');
	}
	
	function detail()
	{
		global $LNG, $USER;

		$noteID		= HTTP::_GP('id', 0);
		
		if(!empty($noteID)) {
            $db = Database::get();

            $sql = "SELECT * FROM %%NOTES%% WHERE id = :noteID AND owner = :userID;";
            $noteDetail = $db->selectSingle($sql, array(
                ':userID'   => $USER['id'],
                ':noteID'   => $noteID
            ));
		} else {
			$noteDetail	= array(
				'id'		=> 0,
				'priority'	=> 1,
				'text'		=> '',
				'title'		=> ''
			);
		}
		
		$this->tplObj->execscript("$('#cntChars').text($('#text').val().length);");
		$this->assign(array(
			'PriorityList'	=> array(2 => $LNG['nt_important'], 1 => $LNG['nt_normal'], 0 => $LNG['nt_unimportant']),
			'noteDetail'	=> $noteDetail,
		));
		
		$this->display('page.notes.detail.tpl');
	}
	
	public function insert()
	{
		global $LNG, $USER;
		$priority 	= HTTP::_GP('priority', 1);
		$title 		= HTTP::_GP('title', '', true);
		$text 		= HTTP::_GP('text', '', true);
		$id			= HTTP::_GP('id', 0);	
		$title 		= !empty($title) ? $title : $LNG['nt_no_title'];
		$text 		= !empty($text) ? $text : $LNG['nt_no_text'];

        $db = Database::get();

		if($id == 0) {
			$sql = "INSERT INTO %%NOTES%% SET owner = :userID, time = :time, priority = :priority, title = :title, text = :text, universe = :universe;";
            $db->insert($sql, array(
                ':userID'   => $USER['id'],
                ':time'     => TIMESTAMP,
                ':priority' => $priority,
                ':title'    => $title,
                ':text'     => $text,
                ':universe' => Universe::current()
            ));
        } else {
			$sql	= "UPDATE %%NOTES%% SET time = :time, priority = :priority, title = :title, text = :text WHERE id = :noteID;";
            $db->update($sql, array(
                ':noteID'   => $id,
                ':time'     => TIMESTAMP,
                ':priority' => $priority,
                ':title'    => $title,
                ':text'     => $text,
            ));
        }
		
		$this->redirectTo('game.php?page=notes');
	}
	
	function delete()
	{
		global $USER;

		$deleteIds	= HTTP::_GP('delmes', array());
		$deleteIds	= array_keys($deleteIds);
		$deleteIds	= array_filter($deleteIds, 'is_numeric');

		if(!empty($deleteIds))
		{
            $sql = 'DELETE FROM %%NOTES%% WHERE id IN ('.implode(', ', $deleteIds).') AND owner = :userID;';
			Database::get()->delete($sql, array(
                ':userID'   => $USER['id'],
            ));
		}
		$this->redirectTo('game.php?page=notes');
	}

}
