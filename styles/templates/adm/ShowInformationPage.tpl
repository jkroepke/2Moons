{include file="adm/overall_header.tpl"}
<center>
<table width="60%">
    <tr>
                <th>Informations-Vorlage zum Posten eines Bugs im <a href="http://bugs.2moons-systems.com/" style="font-size:11px;font-family:Tahoma,sans-serif;" target="tracker">2Moons Bugtracker</a><br>Ohne diese Vorlage gibt es keinen Support!
                        <textarea rows="15">Server Infos: {$info}
PHP-Version: {$vPHP}
PHP API: {$vAPI}
MySQL-Client-Version: {$vMySQLc}
MySQL-Server-Version: {$vMySQLs}
Game Version: 2Moons {$vGame}
Game Addresse: http://{$root}/
Game Pfad: http://{$gameroot}/index.php
JSON Verfügbar: {$json}
Problem besteht seit Installation:
Verwendeter Editor:
Screenshot:
Problembeschreibung:
                        </textarea>
                </th>
    </tr>
</table>
</center>
{include file="adm/overall_footer.tpl"}