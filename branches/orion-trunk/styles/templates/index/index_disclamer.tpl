{extends file="index.tpl"}
{block name="title" prepend}{$LNG.menu_disclamer}{/block}
{block name="content"}
<table>
<tr><td style="font-weight:700">{$LNG.disclamer_name}</td><td>{$smarty.const.DICLAMER_NAME}</td></tr>
<tr><td style="font-weight:700">{$LNG.disclamer_adress}</td><td>{$smarty.const.DICLAMER_ADRESS1}<br>{$smarty.const.DICLAMER_ADRESS2}</td></tr>
<tr><td style="font-weight:700">{$LNG.disclamer_tel}</td><td>{$smarty.const.DICLAMER_TEL}</td></tr>
<tr><td style="font-weight:700">{$LNG.disclamer_email}</td><td>{$smarty.const.DICLAMER_EMAIL}</td></tr>
</table>
<a href="http://www.disclaimer.de/disclaimer.htm?farbe=FFFFFF/000000/000000/000000" target="disclamer">{$disclamer}</a>
{/block}