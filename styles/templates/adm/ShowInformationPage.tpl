{include file="adm/overall_header.tpl"}

<table width="60%">
    <tr>
		<td>{$info_information}
			<textarea rows="25">[daten]Server Infos: {$info}
PHP-Version: {$vPHP}
PHP API: {$vAPI}
[expander=PHP-Config]{$DATA}[/expander]SafeMode: {$safemode}
MemoryLimit: {$memory}
MySQL-Client-Version: {$vMySQLc}
MySQL-Server-Version: {$vMySQLs}
Game Version: 2Moons {$vGame}
Game Addresse: http://{$root}/
Game Pfad: http://{$gameroot}/index.php
JSON Verfügbar: {$json}
BCMath Verfügbar: {$bcmath}
cURL Verfügbar: {$curl}
Browser: {$browser}
Problem besteht seit Installation:
Verwendeter Editor:
Screenshot:
Problembeschreibung


[/daten]</textarea>
		</td>
    </tr>
</table>
{include file="adm/overall_footer.tpl"}