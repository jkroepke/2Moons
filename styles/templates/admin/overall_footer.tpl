{if isset($smarty.get.reload)}
{if $smarty.get.reload == 't'}
<script type="text/javascript">
parent.topFrame.document.location.reload();
</script>
{elseif $smarty.get.reload == 'l'}
<script type="text/javascript">
parent.rightFrame.document.location.reload();
</script>
{elseif $smarty.get.reload == 'r'}
<script type="text/javascript">
top.document.location.reload();
</script>
{/if}
{/if}
</body>
</html>