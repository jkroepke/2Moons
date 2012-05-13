{block name="title" prepend}{$LNG.mu_support}{/block}
{block name="content"}
<table style="width:760px">
    <tr>
		<td>{$info_information}</td>
    </tr>
    <tr>
		<td>
<pre class="left">-- Server Info --
Server Infos: {$info}
PHP-Version: {$vPHP} ({$vAPI})
JSON Verfügbar: {$json}
BCMath Verfügbar: {$bcmath}
cURL Verfügbar: {$curl}
SafeMode: {$safemode}
MemoryLimit: {$memory}
MySQL-Client-Version: {$vMySQLc}
MySQL-Server-Version: {$vMySQLs}
ErrorLog: {$errorlog} ({$errorloglines}, {$log_errors})
Timezone(PHP/CONF/USER): {$php_tz} / {$conf_tz} / {$user_tz}
Suhosin: {$suhosin}

-- Game --
Game Version: 2Moons {$vGame}
Game Addresse: http://{$root}/
Game Pfad: http://{$gameroot}/index.php

Browser: {$browser}</pre>
		</td>
    </tr>
</table>
{/block}