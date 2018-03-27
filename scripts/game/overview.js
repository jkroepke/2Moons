steem.api.getDiscussionsByCreated({"tag": "steemnova", "limit": 3}, function(err, result) {
	if (err === null) {
		$('#feed').css('display', '');
		$('#feed_margin').css('display', '');
		var i, len = result.length;
		for (i = 0; i < len; i++) {
			var discussion = result[i];
			$('#feed_'+i).css('display', '');
			$('#created_'+i).text(discussion['created'].replace("T", " "));
			$('#title_'+i).text(discussion['title']);
			$('#url_'+i).attr('href', 'https://busy.org' + discussion['url']);
			$('#author_'+i).text(' by @' + discussion['author']);
		}
	} else {
		console.log(err);
	}
});

$(document).ready(function()
{
	window.setInterval(function() {
		$('.fleets').each(function() {
			var s		= $(this).data('fleet-time') - (serverTime.getTime() - startTime) / 1000;
			if(s <= 0) {
				$(this).text('-');
			} else {
				$(this).text(GetRestTimeFormat(s));
			}
		})
	}, 1000);
	
	window.setInterval(function() {
		$('.timer').each(function() {
			var s		= $(this).data('time') - (serverTime.getTime() - startTime) / 1000;
			if(s == 0) {
				window.location.href = "game.php?page=overview";
			} else {
				$(this).text(GetRestTimeFormat(s));
			}
		});
	}, 1000);
});
