{include file="adm/overall_header.tpl"}
<center>
<table width="60%">
    <tr>
                <td>{$info_information}
                        <textarea rows="25">Server Infos: {$info}
PHP-Version: {$vPHP}
PHP API: {$vAPI}
phpinfo(): http://{$gameroot}/info/index.php
SafeMode: {$safemode}
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
Problembeschreibung:
                        </textarea>
                </td>
    </tr>
</table>
</center>
{include file="adm/overall_footer.tpl"}