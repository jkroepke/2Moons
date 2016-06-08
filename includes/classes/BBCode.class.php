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

class BBCode
{
	static public function parse($sText)
	{
		// Convert Windows (\r\n) to Unix (\n)
		$sText = str_replace("\r\n", "\n", $sText);

		// Convert Macintosh (\r) to Unix (\n)
		$sText = str_replace("\r", "\n", $sText);

		// [h]eading
		$sText = preg_replace('/\[(h[1-6])](.+?)\[\/(h[1-6])]/i', '<\1>\2</\3>', $sText);

		// [s]trong
		$sText = preg_replace('/\[b](.+?)\[\/b]/i', '<strong>\1</strong>', $sText);

		// [i]talic
		$sText = preg_replace('/\[i](.+?)\[\/i]/i', '<em>\1</em>', $sText);

		// [u]nderline
		$sText = preg_replace('/\[u](.+?)\[\/u]/i', '<span style="text-decoration:underline">\1</span>', $sText);

		// [del]ete
		$sText = preg_replace('/\[del](.+?)\[\/del]/i', '<span style="text-decoration:line-through">\1</span>', $sText);

		// [q]uote
		$sText = preg_replace('/\[q](.+?)\[\/q]/i', '<q>\1</q>', $sText);

		// Blockquote
		$sText = preg_replace('/\[blockquote](.+?)\[\/blockquote]/i', '<blockquote><p>\1</p></blockquote>', $sText);

		// Code
		$sText = preg_replace('/\[code](.+?)\[\/code]/is', '<code>\1</code>', $sText);

		// Size (in pixels)
		$sText = preg_replace('/\[size=(\d{1,2})](.+?)\[\/size]/i', '<span style="font-size:\1px">\2</span>', $sText);

		// Center
		$sText = preg_replace('/\[center](.+?)\[\/center]/i', '<div style="text-align:center">\1</div>', $sText);

		// Color
		$sText = preg_replace('/\[color=(green|lime|olive|red|maroon|navy|blue|teal|aqua|yellow|purple|fuchsia|gold|black|silver|gray|white)\](.+?)\[\/color\]/is', '<span style="color:\1">\2</span>', $sText);

		// Line breaks
		$sText = str_replace("\n", '<br />', $sText);

		/** List **/
		// Unordered List:
		$sText = preg_replace('/\[ul](.+?)\[\/ul]/i', '<ul>\1</ul>', $sText);
		// List Item
		$sText = preg_replace('/\[li](.+?)\[\/li]/i', '<li>\1</li>', $sText);
		// Ordered List
		$sText = preg_replace('/\[ol](.+?)\[\/ol]/i', '<ol>\1</ol>', $sText);

		// [url]link[/url]
		$sText = preg_replace('/\[url]([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\[\/url]/i', '<a href="\1">\1</a>', $sText);

		// [url=url]lien[/url]
		$sText = preg_replace('/\[url=([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)](.+?)\[\/url]/i', '<a href="\1" title="\2">\2</a>', $sText);

		// [img]img link[/img]
		$sText = preg_replace('/\[img]([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\[\/img\]/si', '<img src="\1" alt="Image" />', $sText);

		// [img=img link]title[/img]
		$sText = preg_replace('/\[img=([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)](.+?)\[\/img\]/si', '<img src="\1" alt="\2" title="\2" />', $sText);

		// [email]email address[/email]
		$sText = preg_replace('/\[email]([a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+)\[\/email]/i', '<a href="mailto:\1">\1</a>', $sText);

		// [email=email address]email text[/email]
		$sText = preg_replace('/\[email=([a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+)](.+?)\[\/email]/i', '<a href="mailto:\1" title="\2">\2</a>', $sText);

		return $sText;
	}
}