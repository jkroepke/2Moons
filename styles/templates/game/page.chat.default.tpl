{block name="title" prepend}{$LNG.lm_chat}{/block}
{block name="content"}
<iframe src="./chat/index.php?action={$smarty.get.action|default:''|escape:'html'}" style="border: 0px;width:100%;height:800px;" ALLOWTRANSPARENCY="true"></iframe>
{/block}