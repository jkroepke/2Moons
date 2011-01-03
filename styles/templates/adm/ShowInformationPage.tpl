{include file="adm/overall_header.tpl"}
<center>
<table width="60%">
    <tr>
                <td>{$info_information}
                        <textarea rows="15">Server Infos: {$info}
PHP-Version: {$vPHP}
PHP API: {$vAPI}
MySQL-Client-Version: {$vMySQLc}
MySQL-Server-Version: {$vMySQLs}
Game Version: 2Moons {$vGame}
Game Addresse: http://{$root}/
Game Pfad: http://{$gameroot}/index.php
JSON Verfügbar: {$json}
BCMatd Verfügbar: {$bcmatd}
Browser: {$browser}
Problem besteht seit Installation:
Verwendeter Editor:
Screenshot:
Problembeschreibung:
                        </textarea>
                </td>
    </tr>
</table>
</center>
{include file="adm/overall_footer.tpl"}