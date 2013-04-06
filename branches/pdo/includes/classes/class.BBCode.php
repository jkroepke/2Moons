<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kr�pke
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
 * @author Jan Kr�pke <info@2moons.cc>
 * @copyright 2012 Jan Kr�pke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class BBCode
{
	private $bbCodeObj = null;

	public function __construct()
	{
		require_once 'includes/libs/bbcode/stringparser_bbcode.class.php';
		$this->bbCodeObj = new StringParser_BBCode();

		$this->bbCodeObj->addParser('list', 'bbcode_stripcontents');

		//Block-Elements
		$this->bbCodeObj->addCode('align', 'callback_replace', array($this, 'bbcode_align'), array(), 'block', array('block'), array('inline','link','list'));
		$this->bbCodeObj->addCode('spoiler', 'simple_replace', null, array('start_tag' => '<div class="bbcode_spoiler"><p><b>Spoiler:</b></p><div>', 'end_tag'=>'</div></div>'), 'block', array('block'), array('inline','link','list'));
		$this->bbCodeObj->addCode('bg', 'usecontent?', array($this, 'bbcode_background'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));
		$this->bbCodeObj->addCode('bgcolor', 'callback_replace', array($this, 'bbcode_bgcolor'), array(), 'inline', array('block','inline','link','listitem'), array());

		//Inline-Elements
		$this->bbCodeObj->addCode('b', 'simple_replace', null, array('start_tag'=>'<b>', 'end_tag'=>'</b>'), 'inline', array('block','inline','link','listitem'), array());
		$this->bbCodeObj->addCode('i', 'simple_replace', null, array('start_tag'=>'<i>', 'end_tag'=>'</i>'), 'inline', array('block','inline','link','listitem'), array());
		$this->bbCodeObj->addCode('u', 'simple_replace', null, array('start_tag'=>'<u>', 'end_tag'=>'</u>'), 'inline', array('block','inline','link','listitem'), array());
		$this->bbCodeObj->addCode('s', 'simple_replace', null, array('start_tag'=>'<s>', 'end_tag'=>'</s>'), 'inline', array('block','inline','link','listitem'), array());
		$this->bbCodeObj->addCode('size', 'callback_replace', array($this, 'bbcode_size'), array(), 'inline', array('block','inline','link','listitem'), array());
		$this->bbCodeObj->addCode('color', 'callback_replace', array($this, 'bbcode_color'), array(), 'inline', array('block','inline','link','listitem'), array());

		//Link-Elements
		$this->bbCodeObj->addCode('url', 'usecontent?', array($this, 'bbcode_url'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));
		$this->bbCodeObj->addCode('link', 'usecontent?', array($this, 'bbcode_url'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));
		$this->bbCodeObj->addCode('mailto', 'usecontent?', array($this, 'bbcode_mailto'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));
		$this->bbCodeObj->addCode('email', 'usecontent?', array($this, 'bbcode_mailto'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));
		$this->bbCodeObj->addCode('mail', 'usecontent?', array($this, 'bbcode_mailto'), array('usecontent_param'=>'default'), 'link', array('block','inline','listitem'), array('link'));

		//Code-Elements
		$this->bbCodeObj->addCode('code', 'usecontent', array($this, 'bbcode_code'), array('php'=>false), 'code', array('block'), array('inline','link','list'));
		$this->bbCodeObj->addCode('php', 'usecontent', array($this, 'bbcode_code'), array('php'=>true), 'code', array('block'), array('inline','link','list'));

		//List-Elements
		$this->bbCodeObj->addCode('list', 'callback_replace', array($this, 'bbcode_list'), array(), 'list', array('block', 'listitem'), array('inline', 'link'));
		$this->bbCodeObj->addCode('*', 'simple_replace', null, array('start_tag'=>'<li>', 'end_tag'=>'</li>'), 'listitem', array('list'), array());

		//Image-Element
		$this->bbCodeObj->addCode('img', 'usecontent', array($this, 'bbcode_img'), array(), 'image', array('block','inline','link','listitem'), array());

		//Flags
		$this->bbCodeObj->setCodeFlag('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
		$this->bbCodeObj->setGlobalCaseSensitive (false);

		//New-Line-Drops
		$this->bbCodeObj->setCodeFlag('*', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
		$this->bbCodeObj->setCodeFlag('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
		$this->bbCodeObj->setCodeFlag('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
		$codes = array('code', 'php', 'spoiler');
		$flags = array('opentag.before.newline', 'opentag.after.newline', 'closetag.before.newline', 'closetag.after.newline');
		foreach ($codes as $code) {
			foreach ($flags as $flag) {
				$this->bbCodeObj->setCodeFlag($code, $flag, BBCODE_NEWLINE_DROP);
			}
		}
	}

	public function parse($text)
	{
		return str_replace('&amp;amp;', '&amp;', makebr($this->bbCodeObj->parse($text)));
	}

	public function convertlinebreaks ($text) {
		return preg_replace('/\015\012|\015|\012/', '\n', $text);
	}

	public function bbcode_stripcontents ($text) {
		return preg_replace('/[^\n]/', '', $text);
	}

	public function bbcode_align($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			if (!isset($attributes['default'])) return false;
			$allowed = array('left', 'right', 'center', 'justify');
			if (in_array($attributes['default'], $allowed)) return true;
			return false;
		}
		return '<div style="text-align: '.$attributes['default'].'">'.$content.'</div>';
	}

	public function bbcode_url ($action, $attributes, $content, $params, $node_object) {
		if (!isset ($attributes['default'])) {
			$url = $content;
			$text = htmlspecialchars ($content);
		} else {
			$url = $attributes['default'];
			$text = $content;
		}
		if ($action == 'validate') {
			if (substr ($url, 0, 5) == 'data:' || substr ($url, 0, 5) == 'file:' || substr ($url, 0, 11) == 'javascript:' || substr ($url, 0, 4) == 'jar:' || substr ($url, 0, 1) == '#') {
				return false;
			}
			return true;
		}
		return '<a href="'.htmlspecialchars($url).'">'.$text.'</a>';
	}

	public function bbcode_mailto ($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') return true;
		if (!isset ($attributes['default'])) {
			return '<a href="mailto:'.$content.'">'.$content.'</a>';
		}
		return '<a href="mailto:'.htmlspecialchars($attributes['default']).'">'.$content.'</a>';
	}

	public function bbcode_code($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') return true;
		if ($params['php']) {
			$content = highlight_string(html_entity_decode($content), true);
		}
		$return =  '<div class="bbcode_code';
		if ($params['php']) $return .= '_php';
		$return .= '"><p><b>Code:</b></p><div>'.$content.'</div></div>';
		return $return;
	}

	public function bbcode_img ($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') return true;
		return '<img src="'.htmlentities($content).'" alt="" border="">';
	}

	public function bbcode_background($action, $attributes, $content, $params, $node_object) {
		if (!isset ($attributes['default'])) {
			$url = $content;
			$text = htmlspecialchars($content);
		} else {
			$url = $attributes['default'];
			$text = $content;
		}
		if ($action == 'validate') {
			if (substr ($url, 0, 7) == 'http://') {
				return true;
			}
			return false;
		}
		return '<div style="background: url('.htmlspecialchars($url).');">'.$text.'</div>';
	}

	public function bbcode_list ($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			if (isset($attributes['default'])) {
				return preg_match('|^[0-9]+$|', $attributes['default']);
			}
			return true;
		}
		$this->bbCodeObj = isset($attributes['default']) ? '<ol start="'.$attributes['default'].'">'.$content.'</ol>' : '<ul>'.$content.'</ul>';
		return $this->bbCodeObj;
	}


	public function bbcode_size($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			if (!is_numeric($attributes['default'])) return false;
			if ($attributes['default'] <= 36 && $attributes['default'] >= 4) return true;
			return false;
		}
		return '<span style="font-size: '.htmlspecialchars($attributes['default']).'px">'.$content.'</span>';
	}

	public function bbcode_color($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') return true;
		return '<span style="color: '.htmlspecialchars($attributes['default']).'">'.$content.'</span>';
	}

	public function bbcode_bgcolor($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') return true;
		return '<span style="background: '.htmlspecialchars($attributes['default']).'">'.$content.'</span>';
	}
}