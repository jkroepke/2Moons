steem.api.getDiscussionsByCreated({"tag": "steemnova-rewards", "limit": 1}, function(err, result) {
	if (err === null) {
		$('#feed').css('display', '');
		$('#feed_margin').css('display', '');
		var i, len = result.length;
		for (i = 0; i < len; i++) {
			var discussion = result[i];
			$('#feed_'+i).css('display', '');
			$('#title_'+i).text(discussion['title']);
			$('#url_'+i).attr('href', 'https://busy.org' + discussion['url']);
			$('#votes_'+i).text(discussion['net_votes']);
			$('#pending_payout_value_'+i).text(discussion['pending_payout_value']);
			document.getElementById('image_'+i).src = JSON.parse(discussion['json_metadata']).image[0];
		}
	} else {
		console.log(err);
	}
});