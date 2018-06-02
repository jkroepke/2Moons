<div class="fold">
	<a class="btn" href="#" onclick="toggleAside()">
		<i class="fas fa-angle-double-right"></i>
	</a>
</div>

{for $foo=0 to 3}
<div class="article card" id="aside_card_{$foo}" style="display:none">
	<a id="aside_url_{$foo}" target="_blank">
		<div class="title"><span id="aside_author_{$foo}"></span><span id="aside_date_{$foo}" style="float:right"></span></div>
		<div class="content">
			<img id="aside_image_{$foo}">
			<div><span id="aside_title_{$foo}"></span></div>
		</div>
		<div class="content">
			<div class="payouts">
				<div><i class="fas fa-chevron-circle-up"></i>&nbsp;+<span id="aside_votes_{$foo}"></span></div>
				<div><i class="fas fa-dollar-sign"></i>&nbsp;~<span id="aside_payout_{$foo}"></span></div>
			</div>
		</div>
	</a>
</div>
{/for}

<script>
steem.api.setOptions({ url: 'wss://rpc.buildteam.io' });
steem.api.getDiscussionsByCreated({ "tag": "steemnova-rewards", "limit": 1 }, function(err, result) {
	if (err === null) {
		if (result.length > 0) {
			var discussion = result[0];
			showDiscussion(0, discussion);
		}
	} else {
		console.log(err);
	}
});
steem.api.getDiscussionsByCreated({ "tag": "steemnova", "limit": 3 }, function(err, result) {
	if (err === null) {
		var i, len = result.length;
		for (i = 0; i < len; i++) {
			var discussion = result[i];
			if (JSON.parse(discussion['json_metadata']).tags.indexOf('steemnova-rewards') > -1)
				continue;
			showDiscussion(i+1, discussion);
		}
	} else {
		console.log(err);
	}
});

function showDiscussion(i, discussion){
	$('#aside_image_'+i).attr('src', /(http(s?):)([/|.|\w|\s|-])*/.exec(discussion['body'])[0]);
	$('#aside_author_'+i).text('@'+discussion['author']);
	$('#aside_date_'+i).text(discussion['created'].split('T')[0]);
	$('#aside_title_'+i).text(discussion['title']);
	$('#aside_votes_'+i).text(discussion['net_votes']);
	$('#aside_payout_'+i).text(discussion['pending_payout_value']);
	$('#aside_url_'+i).attr('href', 'https://busy.org' + discussion['url']);
	
	$('#aside_card_'+i).fadeOut();
	$('#aside_card_'+i).delay(100).fadeIn();
}

function toggleAside() {
    $('aside').css('display', 'none');
	$('content').css('grid-column', '3/5');
	$('content').css('max-width', 'unset');
}
</script>