{foreach name=News item=NewsRow from=$NewsList}
{if !$smarty.foreach.News.first}<hr>{/if}
<h2>{$NewsRow.title}</h2><br>
<div class="info">{$NewsRow.from}</div>
<br><div><p>{$NewsRow.text}</p></div>
{foreachelse}
<h1>{$news_does_not_exist}</h1>
{/foreach}