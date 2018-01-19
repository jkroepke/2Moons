{block name="title" prepend}{$LNG.siteTitleNews}{/block}
{block name="content"}
{foreach $newsList as $newsRow}
{if !$newsRow@first}<hr>{/if}
<h2>{$newsRow.title}</h2><br>
<div class="info">{$newsRow.from}</div>
<br><div><p>{$newsRow.text}</p></div>
{foreachelse}
<h1>{$LNG.news_does_not_exist}</h1>
{/foreach}
{/block}